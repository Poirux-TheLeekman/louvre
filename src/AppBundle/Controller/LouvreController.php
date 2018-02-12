<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Command;
use AppBundle\Entity\Ticket;
use AppBundle\Form\CommandType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class LouvreController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function homeAction()
    {
        $welcome = 'Musée du Louvre';
        $new = 'new';

        return $this->render('louvre/home.html.twig', array(
            'welcome' => $welcome,
            'new' => $new,
        ));        
    }

	/**
     * Matches /command/new
     *
     * @Route("/command/new", name="command")
     */
    public function addAction(Request $request)
    {
        //declare mes variables services et paramètres.
        $command = new Command();
        $tickets = new Ticket();
        $agewithservice = $this->get('calculator.date');
        $cost = $this->container->getParameter('ticket.type');
        $reference = $this->get('generate.reference');
        
        $datestring = $command->getDatecommand()->format('Y-m-d H:i:s');
        

        $form = $this->createForm(CommandType::class, $command);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
                
                if ($form->isSubmitted() && $form->isValid()) {
                
                //genere le code référence de la commande.
                $holder = $command->getHolder();
                $ref = $reference->createReference($datestring,$holder);
                $command->setReference($ref);

                
                
                foreach ($command->getTickets() as $tickets) {
                    //lie les tickets à la commande en BDD
                    $tickets->setCommand($command);
 
                    $ag = $agewithservice->ageVisitor($tickets->getBirthday()->format('m/d/Y'));
                    $typeV = $agewithservice->typeVisitor($ag);

                    $tickets->setType($typeV);
                    if ($tickets->getOffer() && $typeV!='Gratuit') {
                        $tickets->setPrice('10');
                    }
                    else {
                        $tickets->setPrice($cost[$typeV]);
                    }


                    $totalOrder = $command->getTotalOrder() + $tickets->getPrice();
                    $command->setTotalOrder($totalOrder);
                      

                }
                
                $dateformat = $tickets->getVisit()->format('Y-m-d');
                $em = $this->getDoctrine()->getManager();
                $nbticket = $em->getRepository('AppBundle\Entity\Ticket')
                ->countNumberVisit($dateformat);
                $limit = $this->get('limit.visit');
                
                $checkLimit = $limit->nbVisit($nbticket);
                
                if($checkLimit) {
                    
                    $this->addFlash("limit", "tous les billets du jour sont déjà vendus");
                           return $this->render('louvre/add.html.twig', array(
                'form' => $form->createView()));
                }
                    
                    
                    $em->persist($command);
                    $em->flush();
                    
                    

                    return $this->render('louvre/charge.html.twig', array(
                    
                    'command'=>$command,
                    'description' => "poursuivre le paiement",
                    "publishable_key" => "pk_test_22Upp5xyncxXUx9EfBE54yEn"
                    ));
            }  
        }     
              
        return $this->render('louvre/add.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * Matches /command/charge
     *
     * @Route("/command/charge", name="charge")
     */
    public function chargeAction(Request $request)
    {

        $commandId = $request->request->get('commandId');

        $em = $this->getDoctrine()->getManager();
        $command = $em->getRepository('AppBundle\Entity\Command')->find($commandId);
        $tickets = $em->getRepository('AppBundle\Entity\Ticket')->findAllTicketsByCommand($commandId);

        $token  = $_POST['stripeToken'];
        $email  = $_POST['stripeEmail'];
        $card = $this->get('stripe.card');
        
        
        try {
            $paid = $card->chargeVisa($token, $email, $command->getTotalOrder());
            $command->setPaid(1);
            $em->persist($command);
            $em->flush();
            
            return $this->render('louvre/bill.html.twig', array(
                    'command'=>$command,
                    'tickets'=>$tickets
                    ));
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("chargeFailed","Oups, le paiement a echoué.");
            return $this->render('louvre/charge.html.twig', array(
                    'command'=>$command,
                    'tickets'=>$tickets,
                    'description' => "poursuivre le paiement",
                    "publishable_key" => "pk_test_22Upp5xyncxXUx9EfBE54yEn"
                    ));
        }

    }

    /**
     * Matches /liste
     * @Route("/liste", name="liste")
     */
    public function listAction()
    {
       
        $datevisit = '2018-01-25';
        $em = $this->getDoctrine()->getManager();
        $genuses = $em->getRepository('AppBundle\Entity\Command')
            ->findAll();
        $nbticket = $em->getRepository('AppBundle\Entity\Ticket')
            ->countNumberVisit($datevisit);

        return $this->render('louvre/list.html.twig',[
            'genuses' => $genuses,
            'nbticket'=> $nbticket,
            'datevisit' => $datevisit
            
        ]);  
    }

    /**
     * @Route("/genus/{genusName}", name="genus_show")
     */
    public function showAction($genusName)
    {
        $em = $this->getDoctrine()->getManager();
        $genus = $em->getRepository('AppBundle\Entity\Command')
            ->findOneBy(['holder' => $genusName]);
        //dump($genuses);die;
        return $this->render('louvre/show.html.twig',[
            'genus' => $genus
        ]);  
    }

}