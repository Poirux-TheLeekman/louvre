<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintDayOffValidator extends ConstraintValidator
{
    const JOUR = [
            '01/01',
            '05/01',
            '05/08',
            '07/14',
            '12/25',
            '11/11',
            '08/15',
        ];

    const MARDI = [
            'Sunday',
            'Tuesday',
            'sun',
            'tue'
        ];

    public function validate($value, Constraint $constraint)
    {
    	
        $dayoff = $value->format('m/d');
        $dayoff2 = $value->format('l');
        

        if(in_array($dayoff,self::JOUR)) {
        	
	        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $dayoff)
            ->addViolation();
        }

        if(in_array($dayoff2,self::MARDI)) {
            
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $dayoff2)
            ->addViolation();
        
        }
    }
}