<?php

namespace Oro\Bundle\IssuesBundle\Entity\Manager;

use Doctrine\ORM\EntityManager;
use Oro\Bundle\IssuesBundle\Entity\Issue;

class IssuesManager
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function deleteIssue(Issue $issue)
    {
        $this->em->remove($issue);
        $this->em->flush();
    }
}