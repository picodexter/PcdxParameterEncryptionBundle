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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterInterface;
use Symfony\Component\Config\Definition\Processor as ConfigurationProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ConfigurationResolver.
 */
class ConfigurationResolver implements ConfigurationResolverInterface
{
    /**
     * @var ConfigurationProcessor
     */
    private $configurationProcessor;

    /**
     * Constructor.
     *
     * @param ConfigurationProcessor $configProcessor
     */
    public function __construct(ConfigurationProcessor $configProcessor)
    {
        $this->configurationProcessor = $configProcessor;
    }

    /**
     * @inheritDoc
     */
    public function getProcessedConfig(RewriterInterface $rewriter, ContainerBuilder $container)
    {
        $extensionConfig = $container->getExtensionConfig($rewriter->getExtensionConfigurationKey());

        $resolvedConfig = $container->getParameterBag()->resolveValue($extensionConfig);

        $processedConfig = $this->configurationProcessor
            ->processConfiguration($rewriter->getConfiguration(), $resolvedConfig);

        return $processedConfig;
    }
}
