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

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration\ServiceDefinition;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterManagerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\ServiceDefinitionProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ServiceDefinitionProcessorTest extends TestCase
{
    /**
     * @var ServiceDefinitionProcessor
     */
    private $processor;

    /**
     * @var RewriterManagerInterface|MockObject
     */
    private $rewriterManager;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->rewriterManager = $this->createRewriterManagerInterfaceMock();

        $this->processor = new ServiceDefinitionProcessor($this->rewriterManager);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->processor = null;
        $this->rewriterManager = null;
    }

    public function testProcessServiceDefinitionsSuccess()
    {
        $container = $this->createContainerBuilderMock();

        $prepServiceNames = [
            'service_1',
            'service_2',
        ];
        $prepServiceDefinitions = [
            $prepServiceNames[0] => $this->createDefinitionMock(),
            $prepServiceNames[1] => $this->createDefinitionMock(),
        ];

        $container->expects($this->once())
            ->method('getDefinitions')
            ->with()
            ->will($this->returnValue($prepServiceDefinitions));

        $this->rewriterManager->expects($this->exactly(2))
            ->method('processServiceDefinition')
            ->withConsecutive(
                [
                    $this->identicalTo($prepServiceNames[0]),
                    $this->identicalTo($prepServiceDefinitions[$prepServiceNames[0]]),
                    $this->identicalTo($container),
                ],
                [
                    $this->identicalTo($prepServiceNames[1]),
                    $this->identicalTo($prepServiceDefinitions[$prepServiceNames[1]]),
                    $this->identicalTo($container),
                ]
            );

        $this->processor->processServiceDefinitions($container);
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['getDefinitions'])
            ->getMock();
    }

    /**
     * Create mock for Definition.
     *
     * @return Definition|MockObject
     */
    private function createDefinitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }

    /**
     * Create mock for RewriterManagerInterface.
     *
     * @return RewriterManagerInterface|MockObject
     */
    private function createRewriterManagerInterfaceMock()
    {
        return $this->getMockBuilder(RewriterManagerInterface::class)->getMock();
    }
}
