<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\IssuesBundle\EventListener\AddNoteSubscriber;
use Oro\Bundle\IssuesBundle\Tests\Unit\Entity\TestNote;


class AddNoteSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /** @var AddNoteSubscriber */
    protected $subscriber;

    /** @var ObjectManager|\PHPUnit_Framework_MockObject_MockObject */
    protected $objectManager;

    public function setUp()
    {
        $this->subscriber = new AddNoteSubscriber();
        $this->objectManager = $this->getMockBuilder(ObjectManager::class)->getMock();
    }

    public function tesNotNote()
    {
        $args = new LifecycleEventArgs(new Issue(), $this->objectManager);

        $this->assertNull($this->subscriber->preUpdate($args));
    }

    public function testTargetNotIssue()
    {
        $note = new TestNote();

        $target = $this->getMockBuilder(\stdClass::class)->getMock();
        $target->expects($this->never())
            ->method('setUpdatedAt');
        $note->setTarget($target);

        $args = new LifecycleEventArgs($note, $this->objectManager);

        $this->subscriber->preUpdate($args);
    }

    public function testRefreshUpdate()
    {
        $note = new TestNote();

        $target = $this->getMockBuilder(Issue::class)->getMock();
        $target->expects($this->once())
            ->method('setUpdatedAt');
        $note->setTarget($target);

        $args = new LifecycleEventArgs($note, $this->objectManager);

        $this->subscriber->preUpdate($args);
    }
}
