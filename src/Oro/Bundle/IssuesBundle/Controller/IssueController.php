<?php

namespace Oro\Bundle\IssuesBundle\Controller;

use Oro\Bundle\IssuesBundle\Form\Handler\IssueHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\IssuesBundle\Entity\IssueType;
use Oro\Bundle\IssuesBundle\Form\Type\IssueType as IssueForm;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

class IssueController extends Controller
{

    /**
     * @Route("/", name="oro_issue_index")
     * @AclAncestor("oro_issues.issue_view")
     *
     * @Template
     */
    public function indexAction()
    {
        return [
            'entity_class' => $this->container->getParameter('oro_issues.entity.class')
        ];
    }

    /**
     * @Route("/latest", name="oro_issues_latest")
     * @AclAncestor("oro_issues.issue_view")
     *
     * @Template("OroIssuesBundle:Dashboard:latestIssues.html.twig")
     */
    public function latestIssuesWidgetAction()
    {
        return array(
            'widgetName' => 'latest_issues'
        );
    }

    /**
     * @Route("/view/{id}", name="oro_issue_view")
     * @Acl(
     *      id="oro_issues.issue_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="OroIssuesBundle:Issue"
     * )
     *
     * @Template
     */
    public function viewAction(Issue $issue)
    {
        return array(
            'issue' => $issue,
            'storyType' => IssueType::STORY,
        );
    }

    /**
     * @Route("/create/{parent}", name="oro_issue_create")
     * @Acl(
     *      id="oro_issues.issue_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="OroIssuesBundle:Issue"
     * )
     *
     * @Template("OroIssuesBundle:Issue:update.html.twig")
     */
    public function createAction(Issue $parent = null)
    {
        $issue = new Issue();

        if ($parent !== null && $parent->getType()->getName() == IssueType::STORY) {
            $issue->setParent($parent);

            $subtask = $this->getDoctrine()->getRepository('OroIssuesBundle:IssueType')->find(IssueType::SUBTASK);
            $issue->setType($subtask);
        }

        return $this->update($issue);
    }
    
    /**
     * @Route("/update/{id}", name="oro_issue_update")
     * @Acl(
     *      id="oro_issues.issue_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="OroIssuesBundle:Issue"
     * )
     *
     * @Template
     */
    public function updateAction(Issue $issue)
    {
        return $this->update($issue);
    }

    /**
     * @param Issue $issue
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function update(Issue $issue)
    {
        $form = $this->createForm(IssueForm::NAME, $issue);

        $handler = new IssueHandler(
            $form,
            $this->getRequest(),
            $this->getDoctrine()->getManagerForClass('OroIssuesBundle:Issue')
        );

        return $this->get('oro_form.model.update_handler')->handleUpdate(
            $issue,
            $form,
            function (Issue $issue) {
                return [
                    'route' => 'oro_issue_update',
                    'parameters' => ['id' => $issue->getId()],
                ];
            },
            function (Issue $issue) {
                return [
                    'route' => 'oro_issue_view',
                    'parameters' => ['id' => $issue->getId()],
                ];
            },
            $this->get('translator')->trans('oro.issues.issue.save'),
            $handler,
            function ($entity, $form, $request) {
                return array(
                    'form' => $form->createView(),
                    'subtask' => IssueType::SUBTASK
                );
            }
        );
    }
}
