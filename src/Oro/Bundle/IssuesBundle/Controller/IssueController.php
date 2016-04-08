<?php

namespace Oro\Bundle\IssuesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class IssueController extends Controller
{

    /**
     * @Route("/", name="oro_issue_index")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/view", name="oro_issue_view")
     * @Template
     */
    public function viewAction()
    {
        return array();
    }

    /**
     * @Route("/delete", name="oro_issue_delete")
     * @Template
     */
    public function deleteAction()
    {
        return array();
    }

    /**
     * @Route("/create", name="oro_issue_create")
     * @Template
     */
    public function createAction()
    {
        return array();
    }

    /**
     * @Route("/create", name="oro_issue_update")
     * @Template
     */
    public function updateAction()
    {
        return array();
    }
}
