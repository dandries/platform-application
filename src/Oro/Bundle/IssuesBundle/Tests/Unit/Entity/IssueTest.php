<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\Entity;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\UserBundle\Entity\User;

class IssueTest extends \PHPUnit_Framework_TestCase
{

    /* @var Issue $issue */
    protected $issue;

    protected function setUp()
    {
        $this->issue = new Issue();
    }

    /**
     * @return array
     */
    public function settersAndGettersDataProvider()
    {
        $user = $this->getMock('Oro\Bundle\UserBundle\Entity\User');
        $user->setId(1);

        $type = $this->getMockBuilder('Oro\Bundle\IssuesBundle\Entity\IssueType')
            ->disableOriginalConstructor()
            ->getMock();
        $status = $this->getMockBuilder('Oro\Bundle\IssuesBundle\Entity\IssueStatus')
            ->disableOriginalConstructor()
            ->getMock();
        $priority = $this->getMockBuilder('Oro\Bundle\IssuesBundle\Entity\IssuePriority')
            ->disableOriginalConstructor()
            ->getMock();
        $resolution = $this->getMockBuilder('Oro\Bundle\IssuesBundle\Entity\IssueResolution')
            ->disableOriginalConstructor()
            ->getMock();

        return array(
            'summary' => array('summary', 'test', 'test'),
            'type' => array('type', $type, $type),
            'status' => array('status', $status, $status),
            'priority' => array('priority', $priority, $priority),
            'resolution' => array('resolution', $resolution, $resolution),
            'assignee' => array('assignee', $user, $user),
            'reporter' => array('reporter', $user, $user),
        );
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     */
    public function testSettersAndGetters($property, $value, $expected)
    {
        call_user_func_array(array($this->issue, 'set' . ucfirst($property)), array($value));
        $this->assertSame($expected, call_user_func_array(array($this->issue, 'get' . ucfirst($property)), array()));
    }

    public function testAddCollaborator()
    {
        $user = new User();
        $user->setId(1);

        $this->issue->setAssignee($user);
        $this->issue->setReporter($user);

        $this->assertEquals(1, $this->issue->getCollaborators()->count());
        $this->assertSame($user, $this->issue->getCollaborators()->first());
    }

    public function testBeforeSave()
    {
        $this->assertNull($this->issue->getCreatedAt());
        $this->assertNull($this->issue->getUpdatedAt());

        $this->issue->beforeSave();

        $this->assertInstanceOf('DateTime', $this->issue->getCreatedAt());
        $this->assertInstanceOf('DateTime', $this->issue->getUpdatedAt());
    }

    public function testToString()
    {
        $this->issue->setSummary('Summary');
        $this->issue->setCode("Code");

        $this->assertEquals('Summary Code', $this->issue->__toString());
    }

    public function testRelatedIssue()
    {
        $this->assertEquals(0, $this->issue->getRelatedIssues()->count());

        $newIssue = new Issue();
        $this->issue->setParent($newIssue);
        $newIssue->addRelatedIssue($this->issue);
    }
}
