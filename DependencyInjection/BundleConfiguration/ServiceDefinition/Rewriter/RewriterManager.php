<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ConfigurationFetcherInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * RewriterManager.
 */
class RewriterManager implements RewriterManagerInterface
{
    /**
     * @var ConfigurationFetcherInterface
     */
    private $configurationFetcher;

    /**
     * @var RewriterRegistryInterface
     */
    private $registry;

    /**
     * Constructor.
     *
     * @param ConfigurationFetcherInterface $configFetcher
     * @param RewriterRegistryInterface     $registry
     */
    public function __construct(
        ConfigurationFetcherInterface $configFetcher,
        RewriterRegistryInterface $registry
    ) {
        $this->configurationFetcher = $configFetcher;
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function processServiceDefinition($serviceId, Definition $definition, ContainerBuilder $container)
    {
        foreach ($this->registry->getRewriters() as $rewriter) {
            $extensionConfig = $this->configurationFetcher->getProcessedConfig($rewriter, $container);

            if (!$extensionConfig) {
                continue;
            }

            if ($rewriter->applies($serviceId, $definition, $extensionConfig)) {
                $rewriter->processServiceDefinition($serviceId, $definition, $extensionConfig);
            }
        }
    }
}
