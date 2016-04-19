<?php

namespace Oro\Bundle\IssuesBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\IssuesBundle\Entity\Issue;

class LoadIssues implements FixtureInterface, DependentFixtureInterface
{
    protected $descriptions = array(
        'Lorem ipsum dolor sit amet, consectetuer adipiscing elit',
        'Aenean commodo ligula eget dolor',
        'Aenean massa',
        'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus',
        'Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem',
        'Nulla consequat massa quis enim',
        'Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu',
        'In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo',
        'Nullam dictum felis eu pede mollis pretium',
        'Integer tincidunt',
        'Cras dapibus',
        'Vivamus elementum semper nisi',
        'Aenean vulputate eleifend tellus',
        'Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim',
        'Aliquam lorem ante, dapibus in, viverra quis, feugiat',
        'Aenean imperdiet. Etiam ultricies nisi vel',
        'Praesent adipiscing',
        'Integer ante arcu',
        'Curabitur ligula sapien',
        'Donec posuere vulputate',
    );

    public function load(ObjectManager $manager)
    {

        $users = $manager->getRepository('OroUserBundle:User')->findAll();
        $types = $manager->getRepository('OroIssuesBundle:IssueType')->findAll();
        $statuses = $manager->getRepository('OroIssuesBundle:IssueStatus')->findAll();
        $resolutions = $manager->getRepository('OroIssuesBundle:IssueResolution')->findAll();
        $priorities = $manager->getRepository('OroIssuesBundle:IssuePriority')->findAll();

        $i = 1;
        $usersCount = count($users);
        $typesCount = count($types);
        $statusesCount = count($statuses);
        $resolutionsCount = count($resolutions);
        $prioritiesCount = count($priorities);


        foreach ($this->descriptions as $description) {

            $issue = new Issue();
            $issue->setSummary('Test issue #' . $i++);
            $issue->setCode('Code' . $i++);
            $issue->setDescription($description);
            $issue->setType($types[rand(0, $typesCount - 1)]);
            $issue->setStatus($statuses[rand(0, $statusesCount - 1)]);
            $issue->setResolution($resolutions[rand(0, $resolutionsCount - 1)]);
            $issue->setPriority($priorities[rand(0, $prioritiesCount - 1)]);
            $issue->setReporter($users[rand(0, $usersCount - 1)]);
            $issue->setAssignee($users[rand(0, $usersCount - 1)]);

            $manager->persist($issue);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return array(
            'Oro\Bundle\IssuesBundle\Migrations\Data\ORM\LoadIssueTypes',
            'Oro\Bundle\IssuesBundle\Migrations\Data\ORM\LoadIssueStatuses',
            'Oro\Bundle\IssuesBundle\Migrations\Data\ORM\LoadIssueResolutions',
            'Oro\Bundle\IssuesBundle\Migrations\Data\ORM\LoadIssuePriorities',
        );
    }
}
