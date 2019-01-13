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

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ConfigurationResolver;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterInterface;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor as ConfigurationProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConfigurationResolverTest extends TestCase
{
    /**
     * @var ConfigurationProcessor|MockObject
     */
    private $configurationProcessor;

    /**
     * @var ConfigurationResolver
     */
    private $resolver;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->configurationProcessor = $this->createConfigurationProcessorMock();

        $this->resolver = new ConfigurationResolver($this->configurationProcessor);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->resolver = null;
        $this->configurationProcessor = null;
    }

    public function testGetProcessedConfigSuccess()
    {
        $prepExtConfigKey = 'some_extension';
        $prepExtensionConfig = [
            'some' => 'config',
        ];
        $prepResolvedConfig = [
            'some' => 'resolved_config',
        ];
        $prepProcessedConfig = [
            'some' => 'processed_config',
        ];

        $rewriter = $this->createRewriterInterfaceMock();
        $configuration = $this->createConfigurationInterfaceMock();
        $container = $this->createContainerBuilderMock();
        $parameterBag = $this->createParameterBagInterfaceMock();

        $rewriter->expects($this->once())
            ->method('getExtensionConfigurationKey')
            ->with()
            ->will($this->returnValue($prepExtConfigKey));

        $container->expects($this->once())
            ->method('getExtensionConfig')
            ->with($this->identicalTo($prepExtConfigKey))
            ->will($this->returnValue($prepExtensionConfig));

        $container->expects($this->once())
            ->method('getParameterBag')
            ->with()
            ->will($this->returnValue($parameterBag));

        $parameterBag->expects($this->once())
            ->method('resolveValue')
            ->with($this->identicalTo($prepExtensionConfig))
            ->will($this->returnValue($prepResolvedConfig));

        $rewriter->expects($this->once())
            ->method('getConfiguration')
            ->with()
            ->will($this->returnValue($configuration));

        $this->configurationProcessor->expects($this->once())
            ->method('processConfiguration')
            ->with(
                $this->identicalTo($configuration),
                $this->identicalTo($prepResolvedConfig)
            )
            ->will($this->returnValue($prepProcessedConfig));

        $processedConfig = $this->resolver->getProcessedConfig($rewriter, $container);

        $this->assertSame($prepProcessedConfig, $processedConfig);
    }

    /**
     * Create mock for ConfigurationInterface.
     *
     * @return ConfigurationInterface|MockObject
     */
    private function createConfigurationInterfaceMock()
    {
        return $this->getMockBuilder(ConfigurationInterface::class)->getMock();
    }

    /**
     * Create mock for ConfigurationProcessor.
     *
     * @return ConfigurationProcessor|MockObject
     */
    private function createConfigurationProcessorMock()
    {
        return $this->getMockBuilder(ConfigurationProcessor::class)->getMock();
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['getExtensionConfig', 'getParameterBag'])
            ->getMock();
    }

    /**
     * Create mock for ParameterBagInterface.
     *
     * @return ParameterBagInterface|MockObject
     */
    private function createParameterBagInterfaceMock()
    {
        return $this->getMockBuilder(ParameterBagInterface::class)->getMock();
    }

    /**
     * Create mock for RewriterInterface.
     *
     * @return RewriterInterface|MockObject
     */
    private function createRewriterInterfaceMock()
    {
        return $this->getMockBuilder(RewriterInterface::class)->getMock();
    }
}
