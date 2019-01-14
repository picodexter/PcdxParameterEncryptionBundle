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
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ConfigurationCacheInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ConfigurationFetcher;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ConfigurationResolverInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConfigurationFetcherTest extends TestCase
{
    /**
     * @var ConfigurationCacheInterface|MockObject
     */
    private $cache;

    /**
     * @var ConfigurationFetcher
     */
    private $fetcher;

    /**
     * @var ConfigurationResolverInterface|MockObject
     */
    private $resolver;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->cache = $this->createConfigurationCacheInterfaceMock();
        $this->resolver = $this->createConfigurationResolverInterfaceMock();

        $this->fetcher = new ConfigurationFetcher($this->cache, $this->resolver);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->fetcher = null;
        $this->resolver = null;
        $this->cache = null;
    }

    public function testGetProcessedConfigSuccessCacheHit()
    {
        $prepProcessedConfig = [
            'some' => 'processed_config',
        ];

        $rewriter = $this->createRewriterInterfaceMock();
        $container = $this->createContainerBuilderMock();

        $this->setUpCacheHas(true);

        $this->cache->expects($this->once())
            ->method('get')
            ->with($this->identicalTo($rewriter))
            ->will($this->returnValue($prepProcessedConfig));

        $processedConfig = $this->fetcher->getProcessedConfig($rewriter, $container);

        $this->assertSame($prepProcessedConfig, $processedConfig);
    }

    public function testGetProcessedConfigSuccessCacheMiss()
    {
        $prepProcessedConfig = [
            'some' => 'processed_config',
        ];

        $rewriter = $this->createRewriterInterfaceMock();
        $container = $this->createContainerBuilderMock();

        $this->setUpCacheHas(false);

        $this->resolver->expects($this->once())
            ->method('getProcessedConfig')
            ->with(
                $this->identicalTo($rewriter),
                $this->identicalTo($container)
            )
            ->will($this->returnValue($prepProcessedConfig));

        $this->cache->expects($this->once())
            ->method('set')
            ->with(
                $this->identicalTo($rewriter),
                $this->identicalTo($prepProcessedConfig)
            );

        $processedConfig = $this->fetcher->getProcessedConfig($rewriter, $container);

        $this->assertSame($prepProcessedConfig, $processedConfig);
    }

    /**
     * Create mock for ConfigurationCacheInterface.
     *
     * @return ConfigurationCacheInterface|MockObject
     */
    private function createConfigurationCacheInterfaceMock()
    {
        return $this->getMockBuilder(ConfigurationCacheInterface::class)->getMock();
    }

    /**
     * Create mock for ConfigurationResolverInterface.
     *
     * @return ConfigurationResolverInterface|MockObject
     */
    private function createConfigurationResolverInterfaceMock()
    {
        return $this->getMockBuilder(ConfigurationResolverInterface::class)->getMock();
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
     * Create mock for RewriterInterface.
     *
     * @return RewriterInterface|MockObject
     */
    private function createRewriterInterfaceMock()
    {
        return $this->getMockBuilder(RewriterInterface::class)->getMock();
    }

    /**
     * Set up cache: has.
     *
     * @param bool $has
     */
    private function setUpCacheHas($has)
    {
        $this->cache->expects($this->once())
            ->method('has')
            ->with()
            ->will($this->returnValue($has));
    }
}
