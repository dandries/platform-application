<?php

namespace Oro\Bundle\IssuesBundle\Tests\Functional\Controller;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

/**
 * @dbIsolation
 */
class DashboardControllerTest  extends WebTestCase
{
    protected function setUp()
    {
        $this->initClient(array(), $this->generateBasicAuthHeader());
    }

    public function testIssuesByStatusChart()
    {
        $this->client->request(
            'GET',
            $this->getUrl('oro_issue_by_status', array('widget' => 'issues_by_status'))
        );

        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
    }
}
