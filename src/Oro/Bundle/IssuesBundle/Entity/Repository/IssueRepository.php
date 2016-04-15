<?php
/**
 * Created by PhpStorm.
 * User: dandries
 * Date: 15.04.2016
 * Time: 15:56
 */

namespace Oro\Bundle\IssuesBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class IssueRepository extends EntityRepository
{

    public function getByStatus()
    {
        $qb = $this->createQueryBuilder('i')
        ->select('s.name as status, COUNT(i.id) as total')
        ->leftJoin('i.status', 's')
        ->groupBy('s.name');

        return $qb->getQuery()->getResult();
    }

}