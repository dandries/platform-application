<?php

namespace Oro\Bundle\IssuesBundle\Controller;

use Oro\Bundle\IssuesBundle\Entity\Issue;
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
     * @Route("/delete/{id}", name="oro_issue_delete", requirements={"id"="\d+"})
     * @Template
     */
    public function deleteAction(Issue $issue)
    {
        $this->get('oro_issues.issue.manager')->deleteIssue($issue);

        if (!$issue) {
            $this->get('session')->getFlashBag()->add(
                'error',
                $this->get('translator')->trans('oro.issues.controller.delete.notfound')
            );
            return $this->redirect($this->generateUrl('dusan_simple_index'));
        }

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('oro.issues.controller.delete.success')
        );        
        
        return $this->redirect($this->generateUrl('oro_issue_index'));
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
