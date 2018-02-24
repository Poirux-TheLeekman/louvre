<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Command;
use AppBundle\Entity\Ticket;
use AppBundle\Form\CommandType;
use AppBundle\Service\Calculator;
use AppBundle\Service\GenerateReference;
use AppBundle\Service\StripeCheckOut;
use AppBundle\Service\Mail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



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
    public function addAction(Request $request, SessionInterface $session, Calculator $calculator, GenerateReference $GenerateReference)
    {
        //declare mes variables services et paramètres.
        $command = new Command();
        $tickets = new Ticket();
        
        $cost = $this->container->getParameter('ticket.type');
       
        
        $datestring = $command->getDatecommand()->format('Y-m-d H:i:s');
        

        $form = $this->createForm(CommandType::class, $command);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
                
                if ($form->isSubmitted() && $form->isValid()) {
                
                //genere le code référence de la commande.
                
                $command->setReference($GenerateReference->createReference($datestring, $command->getHolder()));
                
                foreach ($command->getTickets() as $tickets) {
                    //lie les tickets à la commande en BDD
                    $tickets->setCommand($command);
                    $type = $calculator->typeVisitor($tickets->getBirthday()->format('m/d/Y'));
                    

                    $tickets->setType($type);
                    if ($tickets->getOffer() && $type!='Gratuit') {
                        $tickets->setPrice('10');
                        
                    }
                    else {
                        $tickets->setPrice($cost[$type]);
                    }


                    $totalOrder = $command->getTotalOrder() + $tickets->getPrice();
                    $command->setTotalOrder($totalOrder);
                      

                }
                
                
                $dateformat = $tickets->getVisit()->format('Y-m-d');
                $em = $this->getDoctrine()->getManager();
                $nbticket = $em->getRepository('AppBundle\Entity\Ticket')
                ->countNumberVisit($dateformat);
                $limit = $this->get('limit.visit');

                $checkLimit = $limit->nbVisit($nbticket,count($command->getTickets()));
                
                if($checkLimit) {
                    
                    $this->addFlash("limit", "tous les billets du jour sont déjà vendus, choisir ube autre date.");
                           return $this->render('louvre/add.html.twig', array(
                'form' => $form->createView()));
                }
                    
                    
                    $em->persist($command);
                    $session->set('command',$command);
                    
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
    public function chargeAction(Request $request, SessionInterface $session, StripeCheckOut $stripeCheckOut, Mail $mail)
    {
        
        $command = $session->get('command');
        $em = $this->getDoctrine()->getManager();
        
        $token  = $_POST['stripeToken'];
        $email  = $_POST['stripeEmail'];
        
        
        
        try {
            
            
            $stripeCheckOut->chargeVisa($token, $email, $command->getTotalOrder());
            $em->flush();
            $mail->sendMail($command, $email);
            return $this->render('louvre/bill.html.twig', array(
                    'command'=>$command
                    ));
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("chargeFailed","Oups, le paiement a echoué.");
            return $this->render('louvre/charge.html.twig', array(
                    'command'=>$command,
                    'description' => "poursuivre le paiement",
                    "publishable_key" => "pk_test_22Upp5xyncxXUx9EfBE54yEn"
                    ));
        }

    }

}