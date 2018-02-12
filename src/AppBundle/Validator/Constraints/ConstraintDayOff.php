<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class ConstraintDayOff extends Constraint
{

    public $message = 'le {{ string }}, le musée est fermé. Choisir une autre date.';

}