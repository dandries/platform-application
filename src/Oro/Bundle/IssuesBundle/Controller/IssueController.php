<?php

namespace Oro\Bundle\IssuesBundle\Controller;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\IssuesBundle\Entity\IssueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class IssueController extends Controller
{

    /**
     * @Route("/", name="oro_issue_index")
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
     * @Template("OroIssuesBundle:Issue:update.html.twig")
     */
    public function createAction(Issue $parent = null, Request $request)
    {
        return $this->update(new Issue(), $parent, $request);
    }

    /**
     * @Route("/update/{id}", name="oro_issue_update")
     * @Template
     */
    public function updateAction(Issue $issue, Request $request)
    {
        return $this->update($issue, null, $request);
    }

    /**
     * @Route("/chart/{widget}", name="oro_issue_by_status", requirements={"widget"="[\w-]+"})
     * @Template("OroIssuesBundle:Dashboard:issuesByStatus.html.twig")
     */
    public function issuesByStatusChartAction($widget)
    {
        $issues = $this->getDoctrine()->getRepository('OroIssuesBundle:Issue')->getByStatus();

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
            )
        ))->getView();

        return $widgetOptions;
    }

    private function update(Issue $issue, Issue $parent = null, Request $request)
    {
        $form = $this->get('form.factory')->create('issue_type', $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $issue->setReporter($this->getUser());
            $issue->setStatus();
            $issue->setParent($parent);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($issue);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'oro_issue_update',
                    'parameters' => array('id' => $issue->getId()),
                ),
                array('route' => 'oro_issue_index'),
                $issue
            );
        }

        return array(
            'entity' => $issue,
            'form' => $form->createView(),
        );
    }
}
