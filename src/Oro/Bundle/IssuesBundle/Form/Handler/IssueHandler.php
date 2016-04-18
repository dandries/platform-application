<?php

namespace Oro\Bundle\IssuesBundle\Form\Handler;


use Oro\Bundle\SoapBundle\Form\Handler\ApiFormHandler;

class IssueHandler extends ApiFormHandler
{
    protected function prepareFormData($entity)
    {
        if (!$entity->getAssignee()
            && $this->request->get('_widgetContainer')
            && $this->request->get('entityClass') == 'Oro_Bundle_UserBundle_Entity_User'
        ) {
            $entity->setAssignee(
                $this->entityManager->getRepository('OroUserBundle:User')->find($this->request->get('entityId'))
            );
        }

        return parent::prepareFormData($entity);
    }
}
