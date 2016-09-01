<?php

namespace Oro\Bundle\IssuesBundle\Controller\Api\Soap;

use Symfony\Component\Form\FormInterface;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Oro\Bundle\SoapBundle\Controller\Api\Soap\SoapController;

class IssueController extends SoapController
{
    /**
     * @Soap\Method("getIssues")
     * @Soap\Param("page", phpType="int")
     * @Soap\Param("limit", phpType="int")
     * @Soap\Result(phpType = "Oro\Bundle\IssuesBundle\Entity\IssueSoap[]")
     */
    public function cgetAction($page = 1, $limit = 10)
    {
        return $this->handleGetListRequest($page, $limit);
    }
    /**
     * @Soap\Method("getIssue")
     * @Soap\Param("id", phpType = "int")
     * @Soap\Result(phpType = "Oro\Bundle\IssuesBundle\Entity\IssueSoap")
     */
    public function getAction($id)
    {
        return $this->handleGetRequest($id);
    }
    /**
     * @Soap\Method("createIssue")
     * @Soap\Param("issue", phpType = "Oro\Bundle\IssuesBundle\Entity\IssueSoap")
     * @Soap\Result(phpType = "int")
     */
    public function createAction($issue)
    {
        return $this->handleCreateRequest();
    }
    /**
     * @Soap\Method("updateIssue")
     * @Soap\Param("id", phpType = "int")
     * @Soap\Param("issue", phpType = "Oro\Bundle\IssuesBundle\Entity\IssueSoap")
     * @Soap\Result(phpType = "boolean")
     */
    public function updateAction($id, $issue)
    {
        return $this->handleUpdateRequest($id);
    }
    /**
     * @Soap\Method("deleteIssue")
     * @Soap\Param("id", phpType = "int")
     * @Soap\Result(phpType = "boolean")
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }

    /**
     * Get entity Manager
     *
     * @return ApiEntityManager
     */
    public function getManager()
    {
        return $this->container->get('oro_issues.issue_manager.api');
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->container->get('oro_issues.form.issue.api');
    }
    /**
     * {@inheritdoc}
     */
    public function getFormHandler()
    {
        return $this->container->get('oro_issues.form.handler.issue.api');
    }
}
