<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\ServiceDefinitionProcessorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\UpdateBundleConfigurationServiceDefinitionsWithResolvedParametersPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class UpdateBundleConfigurationServiceDefinitionsWithResolvedParametersPassTest extends TestCase
{
    public function testProcessSuccess()
    {
        $pass = new UpdateBundleConfigurationServiceDefinitionsWithResolvedParametersPass();

        $container = $this->createContainerBuilderMock();
        $processor = $this->createServiceDefinitionProcessorInterfaceMock();

        $container->expects($this->once())
            ->method('get')
            ->with($this->identicalTo(ServiceNames::BUNDLE_CONFIGURATION_SERVICE_DEFINITION_PROCESSOR))
            ->will($this->returnValue($processor));

        $processor->expects($this->once())
            ->method('processServiceDefinitions')
            ->with($this->identicalTo($container));

        $pass->process($container);
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
     * Create mock for ServiceDefinitionProcessorInterface.
     *
     * @return ServiceDefinitionProcessorInterface|MockObject
     */
    private function createServiceDefinitionProcessorInterfaceMock()
    {
        return $this->getMockBuilder(ServiceDefinitionProcessorInterface::class)->getMock();
    }
}
