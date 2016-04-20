<?php


namespace Oro\Bundle\IssuesBundle\Tests\Unit\Form\Type;


use Oro\Bundle\IssuesBundle\Form\Type\IssueType;

class IssueTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IssueType
     */
    protected $type;

    protected function setUp()
    {
        $this->type = new IssueType();
    }

    public function testGetName()
    {
        $this->assertEquals('issue_type', $this->type->getName());
    }

    public function testConfigureOptions()
    {
        $resolver = $this->getMock('Symfony\Component\OptionsResolver\OptionsResolver');

        $this->type->configureOptions($resolver);
    }

    public function testBuildForm()
    {
        $expectedFields = array(
            'summary' => 'text',
            'code' => 'text',
            'description' => 'text',
            'type' => 'entity',
            'status' => 'entity',
            'priority' => 'entity',
            'assignee' => 'entity',
            'tags' => 'oro_tag_select',
        );

        $builder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $counter = 0;
        foreach ($expectedFields as $fieldName => $formType) {
            $builder->expects($this->at($counter))
                ->method('add')
                ->with($fieldName, $formType)
                ->will($this->returnSelf());

            $counter++;
        }

        $this->type->buildForm($builder, array());
    }
}
