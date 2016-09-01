<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\DependencyInjection;

use Oro\Bundle\IssuesBundle\DependencyInjection\OroIssuesExtension;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OroIssuesExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var OroIssuesExtension */
    protected $extension;
    /** @var ContainerBuilder */
    protected $container;

    protected function setUp()
    {
        $this->extension = new OroIssuesExtension();
        $this->container = $this->getMockBuilder(ContainerBuilder::class)->getMock();
    }

    public function testFilesLoaded()
    {
        $this->container->expects($this->exactly(2))
            ->method('addResource')
            ->will(
                $this->returnCallback(
                    function (FileResource $fileResource) {
                        $this->assertEquals(
                            1,
                            preg_match('/services\.yml|importexport\.yml/', $fileResource->getResource())
                        );
                    }
                )
            );
        $this->extension->load([], $this->container);
    }
}
