<?php

namespace Oro\Bundle\IssuesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

class DashboardController extends Controller
{
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
}
