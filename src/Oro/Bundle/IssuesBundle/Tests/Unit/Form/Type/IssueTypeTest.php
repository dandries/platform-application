<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\Form\Type;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Component\Testing\Unit\Form\Type\Stub\EntityType;

use Oro\Bundle\IssuesBundle\Form\Type\IssueType;

use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\FormIntegrationTestCase;

class IssueTypeTest extends FormIntegrationTestCase
{
    /**
     * @var IssueType
     */
    protected $formType;

    protected function setUp()
    {
        parent::setUp();

        $this->formType = new IssueType();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->formType);
    }

    public function testGetName()
    {
        $this->assertEquals('issue_type', $this->formType->getName());
    }

    public function testConfigureOptions()
    {
        $resolver = $this->getMock('Symfony\Component\OptionsResolver\OptionsResolver');

        $this->formType->configureOptions($resolver);
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

        $this->formType->buildForm($builder, array());
    }

    /**
     * @dataProvider submitDataProvider
     *
     * @param array $options
     * @param array $defaultData
     * @param array $viewData
     * @param array $submittedData
     * @param Issue $expectedData
     */
    public function testSubmit(
        array $options,
        array $defaultData = null,
        array $viewData = null,
        array $submittedData,
        Issue $expectedData
    ) {
        $form = $this->factory->create($this->formType);

        $this->assertEquals($defaultData, $form->getData());
        $this->assertEquals($viewData, $form->getViewData());

        $form->submit($submittedData);
        $this->assertTrue($form->isValid());
        $this->assertEquals($expectedData, $form->getData());
    }

    /**
     * @return array
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function submitDataProvider()
    {
        return [
            'default' => [
                'options' => [],
                'defaultData' => null,
                'viewData' => null,
                'submittedData' => [
                    'summary' => 'sum1',
                    'code' => 'code1',
                    'description' => 'desc1',
                    'type' => 'type1',
                    'status' => 'status1',
                    'priority' => 'priority1',
                    'assignee' => 1,
                ],
                'expectedData' => (new Issue())->setSummary('sum1')
                    ->setCode('code1')
                    ->setDescription('desc1')
                    ->setType($this->getEntity('Oro\Bundle\IssuesBundle\Entity\IssueType', 'type1'))
                    ->setTags(null)
            ],
        ];
    }

    /**
     * @param string $className
     * @param string $name
     * @return object
     */
    protected function getEntity($className, $name)
    {
        $entity = new $className($name);

        $reflectionClass = new \ReflectionClass($className);
        $method = $reflectionClass->getProperty('name');
        $method->setAccessible(true);
        $method->setValue($entity, $name);

        return $entity;
    }

    protected function getUser($id) {
        $entity = new User();

        $reflectionClass = new \ReflectionClass(User::class);
        $method = $reflectionClass->getProperty('id');
        $method->setAccessible(true);
        $method->setValue($entity, $id);

        return $entity;
    }

    /**
     * @return array
     */
    protected function getExtensions()
    {
        $issue_types = new EntityType(
            [
                'type1' => $this->getEntity('Oro\Bundle\IssuesBundle\Entity\IssueType', 'type1')
            ],
            'entity'
        );

        return [
            new PreloadedExtension(
                [
                    $issue_types->getName() => $issue_types,
                    'oro_tag_select' => new EntityType([], 'oro_tag_select')
                ],
                []
            )
        ];
    }
}
