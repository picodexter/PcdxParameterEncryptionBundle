<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Loader;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader\XmlFileLoaderFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class XmlFileLoaderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlFileLoaderFactory
     */
    private $factory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->factory = new XmlFileLoaderFactory();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->factory = null;
    }

    public function testCreateXmlFileLoaderSuccess()
    {
        $container = $this->createContainerBuilderMock();
        $fileLocator = $this->createFileLocatorMock();

        $loader = $this->factory->createXmlFileLoader($container, $fileLocator);

        $this->assertInstanceOf(XmlFileLoader::class, $loader);
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)->getMock();
    }

    /**
     * Create mock for FileLocator.
     *
     * @return FileLocator|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createFileLocatorMock()
    {
        return $this->getMockBuilder(FileLocator::class)->getMock();
    }
}
