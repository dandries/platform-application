<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\Form\Type;

use Oro\Bundle\IssuesBundle\Form\Type\IssueApiType;

class IssueApiTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IssueApiType
     */
    protected $type;

    protected function setUp()
    {
        $this->type = new IssueApiType();
    }

    public function testGetName()
    {
        $this->assertEquals('issue_type_api', $this->type->getName());
    }

    public function testGetParent()
    {
        $this->assertEquals('issue_type', $this->type->getParent());
    }

    public function testConfigureOptions()
    {
        $resolver = $this->getMock('Symfony\Component\OptionsResolver\OptionsResolver');

        $this->type->configureOptions($resolver);
    }
}
