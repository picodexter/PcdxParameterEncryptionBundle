<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\AlgorithmInitializerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\ReplacementPatternInitializerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\ReplacementSourceDecrypterInitializerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceDefinitionInitializationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServiceDefinitionInitializationManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlgorithmInitializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $algorithmInitializer;

    /**
     * @var ServiceDefinitionInitializationManager
     */
    private $manager;

    /**
     * @var ReplacementPatternInitializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $replacementPatternInitializer;

    /**
     * @var ReplacementSourceDecrypterInitializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $replacementSourceDecrypterInitializer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->algorithmInitializer = $this->createAlgorithmInitializerInterfaceMock();
        $this->replacementPatternInitializer = $this->createReplacementPatternInitializerInterfaceMock();
        $this->replacementSourceDecrypterInitializer
            = $this->createReplacementSourceDecrypterInitializerInterfaceMock();

        $this->manager = new ServiceDefinitionInitializationManager(
            $this->algorithmInitializer,
            $this->replacementPatternInitializer,
            $this->replacementSourceDecrypterInitializer
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->manager = null;
        $this->replacementSourceDecrypterInitializer = null;
        $this->replacementPatternInitializer = null;
        $this->algorithmInitializer = null;
    }

    public function testInitializeServiceDefinitionsSuccess()
    {
        $bundleConfig = [];

        $container = $this->getContainerBuilderMock();

        $this->replacementPatternInitializer->expects($this->once())
            ->method('initialize')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->algorithmInitializer->expects($this->once())
            ->method('initialize')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->replacementSourceDecrypterInitializer->expects($this->once())
            ->method('initialize')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->manager->initializeServiceDefinitions($bundleConfig, $container);
    }

    /**
     * Create mock for AlgorithmInitializerInterface.
     *
     * @return AlgorithmInitializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createAlgorithmInitializerInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmInitializerInterface::class)->getMock();
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)->getMock();
    }

    /**
     * Create mock for ReplacementPatternInitializerInterface.
     *
     * @return ReplacementPatternInitializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReplacementPatternInitializerInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInitializerInterface::class)->getMock();
    }

    /**
     * Create mock for ReplacementSourceDecrypterInitializerInterface.
     *
     * @return ReplacementSourceDecrypterInitializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReplacementSourceDecrypterInitializerInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementSourceDecrypterInitializerInterface::class)->getMock();
    }
}
