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

	public function nbVisit($nbVisit, $countTicket)
	{
           $limit = $nbVisit + $countTicket;

           return($limit>1000);
	}
}