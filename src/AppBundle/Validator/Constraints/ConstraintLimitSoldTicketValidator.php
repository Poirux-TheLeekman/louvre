<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConstraintLimitSoldTicketValidator extends ConstraintValidator
{

	public function validate($value, Constraint $constraint)
	{
		$checkLimit = true;
		
		/*$limit = $this->get('limit.visit');
		$dateformat = $value->format('Y-m-d');
		$checkLimit = $limit->nbVisit($dateformat);
		dump($limit);*/
		if($checkLimit) {
			$this->context->buildViolation($constraint->message)
            ->addViolation();
		}
		//$em = $this->getDoctrine()->getManager();
		
		/*$nbticket = $em->getRepository('AppBundle\Entity\Ticket')
            ->countNumberPrintedForCategory($limit);
        if($nbticket>4) {
        	$this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $limit)
            ->addViolation();
        }*/
    }
}