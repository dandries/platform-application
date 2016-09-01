<?php

namespace Oro\Bundle\IssuesBundle\Tests\Functional\Entity\Repository;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\IssuesBundle\Entity\Repository\IssueRepository;
use Oro\Bundle\IssuesBundle\Tests\Functional\DataFixtures\LoadIssues;
use Oro\Bundle\IssuesBundle\Tests\Functional\DataFixtures\LoadIssueStatuses;
use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

/**
 * @dbIsolation
 */
class IssueRepositoryTest extends WebTestCase
{
    public function setUp()
    {
        $this->initClient();
        $this->loadFixtures(
            [
                LoadIssues::class
            ]
        );
    }

    public function testGetByStatus()
    {
        /** @var IssueRepository $repository */
        $repository = $this->getContainer()->get('doctrine')->getManagerForClass(Issue::class)
            ->getRepository(Issue::class);

        $this->assertEquals(
            [
                LoadIssueStatuses::STATUS1 => 2,
                LoadIssueStatuses::STATUS2 => 2,
                LoadIssueStatuses::STATUS3 => 1,
            ],
            $repository->getByStatus()
        );
    }
}
