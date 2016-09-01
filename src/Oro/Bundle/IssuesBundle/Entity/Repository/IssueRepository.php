<?php

namespace Oro\Bundle\IssuesBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class IssueRepository extends EntityRepository
{
    /**
     * Get issues grouped by status
     * @return array
     */
    public function getByStatus()
    {
        $qb = $this->createQueryBuilder('i')
        ->select('s.name as status, COUNT(i.id) as total')
        ->leftJoin('i.status', 's')
        ->groupBy('s.name');

        return $qb->getQuery()->getResult();
    }
}
