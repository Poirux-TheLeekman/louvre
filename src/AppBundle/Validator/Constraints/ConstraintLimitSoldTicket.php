<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class ConstraintLimitSoldTicket extends Constraint
{

    public $message = 'Tous les billets pour cette date ont été vendus. 
    				   Choisir une autre date.';

}