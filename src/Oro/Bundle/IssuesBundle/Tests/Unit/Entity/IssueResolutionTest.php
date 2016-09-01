<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\Entity;

use Oro\Bundle\IssuesBundle\Entity\IssueResolution;

class IssueResolutionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function settersAndGettersDataProvider()
    {
        return array(
            'label' => array('label', 'Fixed', 'Fixed'),
        );
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     */
    public function testSettersAndGetters($property, $value, $expected)
    {
        $issueType = new IssueResolution('fixed');
        $this->assertEquals('fixed', $issueType->getName());

        call_user_func_array(array($issueType, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($expected, call_user_func_array(array($issueType, 'get' . ucfirst($property)), array()));
    }
}
