<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ConfigurationFetcherInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterManager;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterRegistryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class RewriterManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigurationFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $configurationFetcher;

    /**
     * @var RewriterManager
     */
    private $manager;

    /**
     * @var RewriterRegistryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $registry;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->configurationFetcher = $this->createConfigurationFetcherInterfaceMock();
        $this->registry = $this->createRewriterRegistryInterfaceMock();

        $this->manager = new RewriterManager($this->configurationFetcher, $this->registry);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->manager = null;
        $this->registry = null;
        $this->configurationFetcher = null;
    }

    public function testProcessServiceDefinitionSuccess()
    {
        $serviceId = 'service_id';

        $prepProcessedConfig = [
            'some' => 'config',
        ];

        $definition = $this->createDefinitionMock();
        $container = $this->createContainerBuilderMock();
        $rewriter = $this->createRewriterInterfaceMock();
        $prepRewriters = [$rewriter];

        $this->setUpRegistryGetRewriters($prepRewriters);

        $this->setUpConfigurationFetcherGetProcessedConfig($prepProcessedConfig);

        $this->setUpRewriterApplies($rewriter, $serviceId, $definition, $prepProcessedConfig, true);

        $rewriter->expects($this->once())
            ->method('processServiceDefinition')
            ->with(
                $this->identicalTo($serviceId),
                $this->identicalTo($definition),
                $this->identicalTo($prepProcessedConfig)
            );

        $this->manager->processServiceDefinition($serviceId, $definition, $container);
    }

    public function testProcessServiceDefinitionSuccessNoExtensionConfig()
    {
        $serviceId = 'service_id';

        $definition = $this->createDefinitionMock();
        $container = $this->createContainerBuilderMock();
        $rewriter = $this->createRewriterInterfaceMock();
        $prepRewriters = [$rewriter];

        $this->setUpRegistryGetRewriters($prepRewriters);

        $this->setUpConfigurationFetcherGetProcessedConfig([]);

        $rewriter->expects($this->never())
            ->method('applies');

        $this->manager->processServiceDefinition($serviceId, $definition, $container);
    }

    public function testProcessServiceDefinitionSuccessRewriterNotApplies()
    {
        $serviceId = 'service_id';

        $prepProcessedConfig = [
            'some' => 'config',
        ];

        $definition = $this->createDefinitionMock();
        $container = $this->createContainerBuilderMock();
        $rewriter = $this->createRewriterInterfaceMock();
        $prepRewriters = [$rewriter];

        $this->setUpRegistryGetRewriters($prepRewriters);

        $this->setUpConfigurationFetcherGetProcessedConfig($prepProcessedConfig);

        $this->setUpRewriterApplies($rewriter, $serviceId, $definition, $prepProcessedConfig, false);

        $rewriter->expects($this->never())
            ->method('processServiceDefinition');

        $this->manager->processServiceDefinition($serviceId, $definition, $container);
    }

    /**
     * Create mock for ConfigurationFetcherInterface.
     *
     * @return ConfigurationFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createConfigurationFetcherInterfaceMock()
    {
        return $this->getMockBuilder(ConfigurationFetcherInterface::class)->getMock();
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

    /**
     * Create mock for Definition.
     *
     * @return Definition|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDefinitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }

    /**
     * Create mock for RewriterInterface.
     *
     * @return RewriterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createRewriterInterfaceMock()
    {
        return $this->getMockBuilder(RewriterInterface::class)->getMock();
    }

    /**
     * Create mock for RewriterRegistryInterface.
     *
     * @return RewriterRegistryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createRewriterRegistryInterfaceMock()
    {
        return $this->getMockBuilder(RewriterRegistryInterface::class)->getMock();
    }

    /**
     * Set up ConfigurationFetcher: getProcessedConfig.
     *
     * @param array $processedConfig
     */
    private function setUpConfigurationFetcherGetProcessedConfig(array $processedConfig)
    {
        $this->configurationFetcher->expects($this->once())
            ->method('getProcessedConfig')
            ->will($this->returnValue($processedConfig));
    }

    /**
     * Set up registry: getRewriters.
     *
     * @param array $rewriters
     */
    private function setUpRegistryGetRewriters(array $rewriters)
    {
        $this->registry->expects($this->once())
            ->method('getRewriters')
            ->with()
            ->will($this->returnValue($rewriters));
    }

    /**
     * Set up rewriter: applies.
     *
     * @param RewriterInterface|\PHPUnit_Framework_MockObject_MockObject $rewriter
     * @param string                                                     $serviceId
     * @param Definition                                                 $definition
     * @param array                                                      $prepProcessedConfig
     * @param bool                                                       $applies
     */
    private function setUpRewriterApplies(
        RewriterInterface $rewriter,
        $serviceId,
        $definition,
        $prepProcessedConfig,
        $applies
    ) {
        $rewriter->expects($this->once())
            ->method('applies')
            ->with(
                $this->identicalTo($serviceId),
                $this->identicalTo($definition),
                $this->identicalTo($prepProcessedConfig)
            )
            ->will($this->returnValue($applies));
    }
}
