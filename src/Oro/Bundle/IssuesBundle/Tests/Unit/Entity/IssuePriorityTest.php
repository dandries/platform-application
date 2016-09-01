<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\Entity;

use Oro\Bundle\IssuesBundle\Entity\IssuePriority;

class IssuePriorityTest extends \PHPUnit_Framework_TestCase
{

    public function settersAndGettersDataProvider()
    {
        return array(
            'label' => array('label', 'Critical', 'Critical'),
            'order' => array('order', 4, 4),
        );
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     */
    public function testSettersAndGetters($property, $value, $expected)
    {
        $issueType = new IssuePriority('critical');
        $this->assertEquals('critical', $issueType->getName());

        call_user_func_array(array($issueType, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($expected, call_user_func_array(array($issueType, 'get' . ucfirst($property)), array()));
    }
}
