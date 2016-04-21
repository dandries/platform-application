<?php

namespace Oro\Bundle\IssuesBundle\Tests\Functional\Controller;

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

    protected function setUp()
    {
        $this->initClient(array(), $this->generateBasicAuthHeader());
        $this->adminUser = $this->getContainer()->get('doctrine')
            ->getRepository('OroUserBundle:User')->findOneByUsername('admin');
    }

    public function testCreate()
    {
        $crawler = $this->client->request('GET', $this->getUrl('oro_issue_create'));
        $form = $crawler->selectButton('Save and Close')->form();

        $form['issue_type_form[summary]'] = 'Test summary';
        $form['issue_type_form[code]'] = 'Test code';
        $form['issue_type_form[description]'] = 'Test description';
        $form['issue_type_form[type]'] = 'task';
        $form['issue_type_form[priority]'] = 'minor';
        $form['issue_type_form[assignee]'] = $this->adminUser->getId();

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);

        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains("Issue saved successfully", $crawler->html());
    }

    /**
     * @depends testCreate
     */
    public function testIndex()
    {
        $this->client->request('GET', $this->getUrl('oro_issue_index'));
        $result = $this->client->getResponse();

        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains('Test summary', $result->getContent());
    }

    /**
     * @depends testCreate
     * @return int
     */
    public function testUpdate()
    {
        $response = $this->client->requestGrid(
            'issues-grid'
        );

        $result = $this->getJsonResponseContent($response, 200);
        $result = reset($result['data']);
        $id = $result['id'];

        $crawler = $this->client->request(
            'GET',
            $this->getUrl('oro_issue_update', array('id' => $result['id']))
        );
        $form = $crawler->selectButton('Save and Close')->form();
        $form['issue_type_form[summary]'] = 'Summary update';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);
        $result = $this->client->getResponse();

        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains("Issue saved successfully", $crawler->html());

        return $id;
    }

    /**
     * @depends testUpdate
     * @param int $id
     */
    public function testView($id)
    {
        $crawler = $this->client->request(
            'GET',
            $this->getUrl('oro_issue_view', array('id' => $id))
        );
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains("Summary update", $crawler->html());
    }
}
