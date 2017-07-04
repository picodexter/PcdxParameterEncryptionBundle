<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ConfigurationFetcher.
 */
class ConfigurationFetcher implements ConfigurationFetcherInterface
{
    /**
     * @var ConfigurationCacheInterface
     */
    private $cache;

    /**
     * @var ConfigurationResolverInterface
     */
    private $resolver;

    /**
     * Constructor.
     *
     * @param ConfigurationCacheInterface    $cache
     * @param ConfigurationResolverInterface $resolver
     */
    public function __construct(ConfigurationCacheInterface $cache, ConfigurationResolverInterface $resolver)
    {
        $this->cache = $cache;
        $this->resolver = $resolver;
    }

    /**
     * @inheritDoc
     */
    public function getProcessedConfig(RewriterInterface $rewriter, ContainerBuilder $container)
    {
        if (!$this->cache->has($rewriter)) {
            $processedConfig = $this->resolver->getProcessedConfig($rewriter, $container);

            $this->cache->set($rewriter, $processedConfig);
        } else {
            $processedConfig = $this->cache->get($rewriter);
        }

        return $processedConfig;
    }
}
