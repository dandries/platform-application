<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\Entity;

use Oro\Bundle\IssuesBundle\Entity\IssueStatus;

class IssueStatusTest extends \PHPUnit_Framework_TestCase
{

    public function settersAndGettersDataProvider()
    {
        return array(
            'label' => array('label', 'New', 'New'),
            'order' => array('order', 1, 1),
        );
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     */
    public function testSettersAndGetters($property, $value, $expected)
    {
        $issueType = new IssueStatus('new');
        $this->assertEquals('new', $issueType->getName());

        call_user_func_array(array($issueType, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($expected, call_user_func_array(array($issueType, 'get' . ucfirst($property)), array()));
    }
}
