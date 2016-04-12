<?php

namespace Oro\Bundle\IssuesBundle\Controller\Api\Rest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Oro\Bundle\SoapBundle\Form\Handler\ApiFormHandler;

/**
 * @RouteResource("issue")
 * @NamePrefix("oro_issues_api_")
 */
class IssueController extends RestController
{

    /**
     * REST GET LIST ISSUE
     *
     * @QueryParam(
     *      name="page",
     *      requirements="\d+",
     *      nullable=true,
     *      description="Page number, starting from 1. Defaults to 1."
     * )
     * @QueryParam(
     *      name="limit",
     *      requirements="\d+",
     *      nullable=true,
     *      description="Number of items per page. defaults to 10."
     * )
     * @ApiDoc(
     *      description="Get all issues",
     *      resource=true
     * )
     *
     * @return Response
     */
    public function cgetAction(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $limit = (int)$request->get('limit', self::ITEMS_PER_PAGE);
        return $this->handleGetListRequest($page, $limit);
    }

    /**
     * REST GET ISSUE
     *
     * @param integer $id
     *
     * @ApiDoc(
     *      description="Get issue",
     *      resource=true
     * )
     *
     * @return Response
     */
    public function getAction($id)
    {
        return $this->handleGetRequest($id);
    }


    /**
     * REST PUT ISSUE
     *
     * @param integer $id
     *
     * @ApiDoc(
     *      description="Update issue",
     *      resource=true
     * )
     *
     * @return Response
     */
    public function putAction($id)
    {
        return $this->handleUpdateRequest($id);
    }
    /**
     * REST POST ISSUE
     *
     * @ApiDoc(
     *      description="Create new issue",
     *      resource=true
     * )
     */
    public function postAction()
    {
        return $this->handleCreateRequest();
    }

    /**
     * REST DELETE ISSUE
     *
     * @param int $id
     *
     * @ApiDoc(
     *      description="Delete issue",
     *      resource=true
     * )
     *
     * @return Response
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
        return $this->get('oro_issues.issue_manager.api');
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->get('oro_issues.form.issue.api');
    }
    /**
     * {@inheritdoc}
     */
    public function getFormHandler()
    {
        return $this->get('oro_issues.form.handler.issue.api');
    }
}
