<?php

namespace AppBundle\Repository;

/**
 * CommandRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandRepository extends \Doctrine\ORM\EntityRepository
{
	public function findAllPublishedOrderedBySize()
    {
		return $this->createQueryBuilder('command')
            //->andWhere('command.holder = zidane')
            //->setParameter('isPublished', true)
            ->orderBy('command.holder', 'ASC')
            ->orderBy('command.datecommand', 'ASC')
            ->getQuery()
            ->execute();
    }
}