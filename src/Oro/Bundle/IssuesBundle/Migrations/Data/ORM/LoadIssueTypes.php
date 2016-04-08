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
use Oro\Bundle\IssuesBundle\Entity\IssueType;

class LoadIssueTypes implements FixtureInterface
{

    protected $data = array(
        'task' => 'Task',
        'story' => 'Story',
        'subtask' => 'Sub-Task',
        'bug' => 'Bug',
    );

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $name => $label) {
            $type = new IssueType($name);
            $type->setLabel($label);
            $manager->persist($type);
        }

        $manager->flush();
    }
}