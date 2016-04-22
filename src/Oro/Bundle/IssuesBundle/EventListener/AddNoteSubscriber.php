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

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Note) {
            return;
        }

        $metadata = $args->getEntityManager()->getClassMetadata(get_class($entity));

        foreach ($metadata->associationMappings as $associationMappingKey => $associationMapping) {
            if (strpos($associationMappingKey, self::ISSUE_ASSOCIATION_NAME) !== false) {
                $getter = 'get' . str_replace('_', '', $associationMappingKey);
                $issue = $entity->$getter();

                if ($issue instanceof Issue) {
                    $issue->setUpdatedAt(new \DateTime());
                }
            }
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->preUpdate($args);
    }
}
