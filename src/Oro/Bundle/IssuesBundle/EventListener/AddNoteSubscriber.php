<?php

namespace Oro\Bundle\IssuesBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\NoteBundle\Entity\Note;

class AddNoteSubscriber implements EventSubscriber
{

    const ISSUE_ASSOCIATION_NAME = 'issue';

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'preUpdate',
            'prePersist'
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Note) {
            return;
        }

        $issue = $entity->getTarget();
        
        if (!$issue instanceof Issue) {
            return;
        }

        $issue->setUpdatedAt(new \DateTime());;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->preUpdate($args);
    }
}
