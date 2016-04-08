<?php
/**
 * Created by PhpStorm.
 * User: dandries
 * Date: 07.04.2016
 * Time: 17:32
 */

namespace Oro\Bundle\IssuesBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\IssuesBundle\Entity\IssueStatus;

class LoadIssueStatuses implements FixtureInterface
{

    protected $data = array(
        'new' => 'New',
        'in_progress' => 'In progress',
        'resolved' => 'Resolved',
        'closed' => 'Closed',
        'reopened' => 'Reopened',
    );

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $name => $label) {
            $status = new IssueStatus($name);
            $status->setLabel($label);
            $manager->persist($status);
        }

        $manager->flush();
    }
}