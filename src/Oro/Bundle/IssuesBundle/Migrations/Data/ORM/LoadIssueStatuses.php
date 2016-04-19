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
        'new' => array('label' => 'New', 'order' => 1),
        'in_progress' => array('label' => 'In progress', 'order' => 2),
        'resolved' => array('label' => 'Resolved', 'order' => 3),
        'closed' => array('label' => 'Closed', 'order' => 4),
        'reopened' => array('label' => 'Reopened', 'order' => 5),
    );

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $name => $details) {
            $priority = new IssueStatus($name);
            $priority->setLabel($details['label']);
            $priority->setOrder($details['order']);
            $manager->persist($priority);
        }

        $manager->flush();
    }
}