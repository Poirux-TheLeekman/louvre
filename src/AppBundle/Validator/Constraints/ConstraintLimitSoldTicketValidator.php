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

		$nbticketBdd = $this->em->getRepository('AppBundle\Entity\Ticket')
                ->countNumberVisit($value->format('Y-m-d'))+1;
		
		if($nbticketBdd>self::LIMIT) {
			$this->context->buildViolation($constraint->message)
            ->addViolation();
		}
		
    }
}