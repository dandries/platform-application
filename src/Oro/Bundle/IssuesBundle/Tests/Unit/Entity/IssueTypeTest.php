<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\Entity;

use Oro\Bundle\IssuesBundle\Entity\IssueType;

class IssueTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function settersAndGettersDataProvider()
    {
        return array(
            'label' => array('label', 'Task', 'Task'),
        );
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     */
    public function testSettersAndGetters($property, $value, $expected)
    {
        $issueType = new IssueType('task');
        $this->assertEquals('task', $issueType->getName());

        call_user_func_array(array($issueType, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($expected, call_user_func_array(array($issueType, 'get' . ucfirst($property)), array()));
    }
}
