<?php

namespace Oro\Bundle\IssuesBundle\Controller;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\IssuesBundle\Entity\IssueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/chart/{widget}", name="oro_issue_by_status", requirements={"widget"="[\w-]+"})
     * @AclAncestor("oro_issues.issue_view")
     *
     * @Template("OroIssuesBundle:Dashboard:issuesByStatus.html.twig")
     */
    public function issuesByStatusChartAction($widget)
    {
        $issues = $this->getDoctrine()->getRepository('OroIssuesBundle:Issue')->getByStatus();

        $translator = $this->get('translator');

        foreach ($issues as &$item) {
            $item['status'] = $translator->trans($item['status']);
        }

        $widgetOptions = $this->get('oro_dashboard.widget_configs')->getWidgetAttributesForTwig($widget);
        $widgetOptions['chartView'] = $this->get('oro_chart.view_builder')
        ->setArrayData($issues)
        ->setOptions(array(
            'name' => 'bar_chart',
            'data_schema' =>array(
                'label' => array(
                    'field_name' => 'status',
                    'label' => 'oro.issues.issue_status_chart.status',
                    'type' => 'string'
                ),
                'value' => array(
                    'field_name' => 'total',
                    'label' => 'oro.issues.issue_status_chart.total',
                    'type' => 'number'
                )
            ),
            'settings' => array(
                'xNoTicks' => count($issues)
            )
        ))->getView();

        return $widgetOptions;
    }

    private function update(Issue $issue)
    {
        return $this->get('oro_form.model.update_handler')->handleUpdate(
            $issue,
            $this->get('oro_issues.form.handler.issue.api')->getForm(),
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
            $this->get('oro_issues.form.handler.issue.api'),
            function ($entity, $form, $request) {
                return array(
                    'form' => $form->createView(),
                    'subtask' => IssueType::SUBTASK
                );
            }
        );
    }
}
