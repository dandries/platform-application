<?php

namespace Oro\Bundle\IssuesBundle\Tests\Functional\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\IssuesBundle\Entity\Issue;


class LoadIssues extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            LoadIssueTypes::TYPE1 => LoadIssueStatuses::STATUS1,
            LoadIssueTypes::TYPE2 => LoadIssueStatuses::STATUS2,
            LoadIssueTypes::TYPE3 => LoadIssueStatuses::STATUS1,
            LoadIssueTypes::TYPE3 => LoadIssueStatuses::STATUS2,
            LoadIssueTypes::TYPE1 => LoadIssueStatuses::STATUS3,
        ];

        foreach ($data as $type => $status) {
            $manager->persist($this->createIssue($type, $status));
        }

        $manager->flush();
    }

    protected function createIssue($type, $status)
    {
        $issue = new Issue();
        $issue->setSummary('summary')
            ->setCode('123')
            ->setDescription('description')
            ->setType($this->getReference($type))
            ->setStatus($this->getReference($status))
            ->setPriority($this->getReference(LoadIssuePriorities::PRIORITY1))
            ->setResolution($this->getReference(LoadIssueResolutions::RESOLUTION1));

        return $issue;
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return [
            LoadIssueStatuses::class,
            LoadIssuePriorities::class,
            LoadIssueTypes::class,
            LoadIssueResolutions::class,
        ];
    }
}
