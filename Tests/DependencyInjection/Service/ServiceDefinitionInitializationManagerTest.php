<?php

declare(strict_types=1);

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\AlgorithmInitializerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\ReplacementPatternInitializerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\ReplacementSourceDecrypterInitializerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceDefinitionInitializationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServiceDefinitionInitializationManagerTest extends TestCase
{
    /**
     * @var AlgorithmInitializerInterface|MockObject
     */
    private $algorithmInitializer;

    /**
     * @var ServiceDefinitionInitializationManager
     */
    private $manager;

    /**
     * @var ReplacementPatternInitializerInterface|MockObject
     */
    private $replacementPatternInitializer;

    /**
     * @var ReplacementSourceDecrypterInitializerInterface|MockObject
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

        $container = $this->createContainerBuilderMock();

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
     * @return AlgorithmInitializerInterface|MockObject
     */
    private function createAlgorithmInitializerInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmInitializerInterface::class)->getMock();
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['get'])
            ->getMock();
    }

    /**
     * Create mock for ReplacementPatternInitializerInterface.
     *
     * @return ReplacementPatternInitializerInterface|MockObject
     */
    private function createReplacementPatternInitializerInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInitializerInterface::class)->getMock();
    }

    /**
     * Create mock for ReplacementSourceDecrypterInitializerInterface.
     *
     * @return ReplacementSourceDecrypterInitializerInterface|MockObject
     */
    private function createReplacementSourceDecrypterInitializerInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementSourceDecrypterInitializerInterface::class)->getMock();
    }
}
