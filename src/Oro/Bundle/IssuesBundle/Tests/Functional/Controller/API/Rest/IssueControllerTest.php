<?php

namespace Oro\Bundle\IssuesBundle\Tests\Functional\Controller\API\Rest;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * @dbIsolation
 */
class IssueControllerTest extends WebTestCase
{
    /**
     * @var User
     */
    protected $adminUser;

    /**
     * @var array
     */
    protected $issuePostData = array(
        'summary' => 'Test summary',
        'code' => 'Test code',
        'description' => 'Test Description',
        'type' => 'task',
        'priority' => 'minor',
        'assignee' => null,
    );

    protected function setUp()
    {
        $this->initClient(array(), $this->generateWsseAuthHeader());

        $this->adminUser = $this->getContainer()->get('doctrine')
            ->getRepository('OroUserBundle:User')->findOneByUsername('admin');

        $this->issuePostData['assignee'] = $this->adminUser->getId();
    }

    /**
     * @return array
     */
    public function testPost()
    {
        $request = array(
            'issue_type_form' => $this->issuePostData
        );
        $this->client->request(
            'POST',
            $this->getUrl('oro_issues_api_post_issue'),
            $request
        );

        $response = $this->getJsonResponseContent($this->client->getResponse(), 201);
        $this->assertArrayHasKey('id', $response);

        return $response['id'];
    }

    /**
     * @depends testPost
     */
    public function testCget()
    {
        $this->client->request(
            'GET',
            $this->getUrl('oro_issues_api_get_issues'),
            array(),
            array(),
            $this->generateWsseAuthHeader()
        );

        $issues = $this->getJsonResponseContent($this->client->getResponse(), 200);

        $this->assertCount(1, $issues);
        $this->checkIssue($issues[0]);
    }

    /**
     * @depends testPost
     * @param integer $id
     * @return array
     */
    public function testGet($id)
    {
        $this->client->request(
            'GET',
            $this->getUrl('oro_issues_api_get_issue', array('id' => $id)),
            array(),
            array(),
            $this->generateWsseAuthHeader()
        );

        $issue = $this->getJsonResponseContent($this->client->getResponse(), 200);

        $this->checkIssue($issue);

        return $issue;
    }

    /**
     * @param array $originalIssue
     * @depends testGet
     */
    public function testPut(array $originalIssue)
    {
        $id = $originalIssue['id'];

        $putData = array(
            'summary' => 'Updated summary',
            'code' => 'Updated code',
            'description' => 'Updated description',
            'type' => 'story',
        );

        $this->client->request(
            'PUT',
            $this->getUrl('oro_issues_api_put_issue', array('id' => $id)),
            array('issue_type_form' => $putData),
            array(),
            $this->generateWsseAuthHeader()
        );

        $result = $this->client->getResponse();
        $this->assertEmptyResponseStatusCodeEquals($result, 204);

        $this->client->request(
            'GET',
            $this->getUrl('oro_issues_api_get_issue', array('id' => $id))
        );

        $updatedIssue = $this->getJsonResponseContent($this->client->getResponse(), 200);

        $putData['type'] = ucfirst($putData['type']);
        $expectedIssue = array_merge($originalIssue, $putData);

        unset($expectedIssue['updatedAt']);
        unset($updatedIssue['updatedAt']);

        $this->assertArrayIntersectEquals($expectedIssue, $updatedIssue);

        return $id;
    }

    /**
     * @param int $id
     * @depends testPut
     */
    public function testDelete($id)
    {
        $this->client->request(
            'DELETE',
            $this->getUrl('oro_issues_api_delete_issue', array('id' => $id))
        );

        $result = $this->client->getResponse();
        $this->assertEmptyResponseStatusCodeEquals($result, 204);

        $this->client->request(
            'GET',
            $this->getUrl('oro_issues_api_delete_issue', array('id' => $id))
        );
        $result = $this->client->getResponse();

        $this->assertJsonResponseStatusCodeEquals($result, 404);
    }

    private function checkIssue($actual = array())
    {
        $this->assertArrayIntersectEquals(
            array(
                'summary' => $this->issuePostData['summary'],
                'code' => $this->issuePostData['code'],
                'description' => $this->issuePostData['description'],
                'type' => ucfirst($this->issuePostData['type']),
                'priority' => ucfirst($this->issuePostData['priority']),
            ),
            $actual
        );

        $this->assertArrayHasKey('createdAt', $actual);
        $this->assertNotEmpty($actual['createdAt']);
        $this->assertArrayHasKey('updatedAt', $actual);
        $this->assertNotEmpty($actual['updatedAt']);
        ;
        $this->assertArrayHasKey('id', $actual);
        $this->assertGreaterThan(0, $actual['id']);
    }
}
