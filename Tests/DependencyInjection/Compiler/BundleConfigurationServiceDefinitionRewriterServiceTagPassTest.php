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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\BundleConfigurationServiceDefinitionRewriterServiceTagPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\BundleConfigurationServiceDefinitionRewriterTagProcessorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BundleConfigurationServiceDefinitionRewriterServiceTagPassTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessSuccess()
    {
        $pass = new BundleConfigurationServiceDefinitionRewriterServiceTagPass();

        $container = $this->createContainerBuilderMock();
        $processor = $this->createBundleConfigurationServiceDefinitionRewriterTagProcessorInterfaceMock();

        $container->expects($this->once())
            ->method('get')
            ->with($this->identicalTo(
                ServiceNames::SERVICE_TAG_PROCESSOR_BUNDLE_CONFIGURATION_SERVICE_DEFINITION_REWRITER
            ))
            ->will($this->returnValue($processor));

        $processor->expects($this->once())
            ->method('process')
            ->with($this->identicalTo($container));

        $pass->process($container);
    }

    /**
     * Create mock for BundleConfigurationServiceDefinitionRewriterTagProcessorInterface.
     *
     * @return BundleConfigurationServiceDefinitionRewriterTagProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createBundleConfigurationServiceDefinitionRewriterTagProcessorInterfaceMock()
    {
        return $this->getMockBuilder(BundleConfigurationServiceDefinitionRewriterTagProcessorInterface::class)->getMock(
        );
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['get'])
            ->getMock();
    }
}