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

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Definition;

/**
 * RewriterInterface.
 */
interface RewriterInterface
{
    /**
     * Getter: configuration.
     *
     * @return ConfigurationInterface
     */
    public function getConfiguration();

    /**
     * Check if this rewriter applies.
     *
     * @param string     $serviceId
     * @param Definition $definition
     * @param array      $extensionConfig
     *
     * @return bool
     */
    public function applies($serviceId, Definition $definition, array $extensionConfig);

    /**
     * Get extension configuration key.
     *
     * @return string
     */
    public function getExtensionConfigurationKey();

    /**
     * Process service definition.
     *
     * @param string     $serviceId
     * @param Definition $definition
     * @param array      $extensionConfig
     */
    public function processServiceDefinition($serviceId, Definition $definition, array $extensionConfig);
}
