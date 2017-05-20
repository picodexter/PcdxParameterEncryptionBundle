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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader\BundleServiceDefinitionsLoader;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader\FileLocatorFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader\XmlFileLoaderFactoryInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BundleServiceDefinitionsLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileLocatorFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $fileLocatorFactory;

    /**
     * @var BundleServiceDefinitionsLoader
     */
    private $loader;

    /**
     * @var XmlFileLoaderFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $xmlFileLoaderFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->fileLocatorFactory = $this->createFileLocatorFactoryInterfaceMock();
        $this->xmlFileLoaderFactory = $this->createXmlFileLoaderFactoryInterfaceMock();

        $this->loader = new BundleServiceDefinitionsLoader($this->fileLocatorFactory, $this->xmlFileLoaderFactory);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->loader = null;
        $this->xmlFileLoaderFactory = null;
        $this->fileLocatorFactory = null;
    }

    public function testLoadBundleServiceDefinitionsSuccess()
    {
        $container = $this->createContainerBuilderMock();
        $fileLoader = $this->createFileLoaderMock();
        $fileLocator = $this->createFileLocatorMock();

        $this->xmlFileLoaderFactory->expects($this->once())
            ->method('createXmlFileLoader')
            ->with(
                $this->identicalTo($container),
                $this->identicalTo($fileLocator)
            )
            ->will($this->returnValue($fileLoader));

        $this->fileLocatorFactory->expects($this->once())
            ->method('createFileLocator')
            ->will($this->returnValue($fileLocator));

        $fileLoader->expects($this->once())
            ->method('load')
            ->with($this->identicalTo('services.xml'));

        $this->loader->loadBundleServiceDefinitions($container);
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
     * Create mock for FileLoader.
     *
     * @return FileLoader|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createFileLoaderMock()
    {
        return $this->getMockBuilder(FileLoader::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for FileLocatorFactoryInterface.
     *
     * @return FileLocatorFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createFileLocatorFactoryInterfaceMock()
    {
        return $this->getMockBuilder(FileLocatorFactoryInterface::class)->getMock();
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

    /**
     * Create mock for XmlFileLoaderFactoryInterface.
     *
     * @return XmlFileLoaderFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createXmlFileLoaderFactoryInterfaceMock()
    {
        return $this->getMockBuilder(XmlFileLoaderFactoryInterface::class)->getMock();
    }
}
