<?php
namespace AppBundle\Service;
//use Doctrine\ORM\EntityManagerInterface;

class LimitVisit
{
/*	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
		dump($em);
	}*/

	public function nbVisit($nbVisit)
	{
            if($nbVisit>1000) {
            	return true;
            }
            else {
            	return false;
            }
	}
}