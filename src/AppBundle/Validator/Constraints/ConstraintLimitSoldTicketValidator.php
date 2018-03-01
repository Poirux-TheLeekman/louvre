<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConstraintLimitSoldTicketValidator extends ConstraintValidator
{

	const LIMIT = 1000;
	protected $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
		
		
	}


	public function validate($value, Constraint $constraint)
	{
		$countTickets = [];

		foreach ($value->getTickets() as $k => $ticket) {

			if(!isset($countTickets[$ticket->getVisit()->format('Y-m-d')])) {
				
				$countTickets[$ticket->getVisit()->format('Y-m-d')] = $this->em->getRepository('AppBundle\Entity\Ticket')
                ->countNumberVisit($ticket->getVisit()->format('Y-m-d'));
   
                
			}

			$countTickets[$ticket->getVisit()->format('Y-m-d')]++;
			

			if($countTickets[$ticket->getVisit()->format('Y-m-d')]>self::LIMIT) {
				
				$this->context->buildViolation($constraint->message)
	            ->atPath('tickets['.$k.'].visit')
	            ->addViolation();
			}
		}

		/*$nbticketBdd = $this->em->getRepository('AppBundle\Entity\Ticket')
                ->countNumberVisit($value->format('Y-m-d'))+$countTickets[$value->format('Y-m-d')];*/
		
		
		
    }
}