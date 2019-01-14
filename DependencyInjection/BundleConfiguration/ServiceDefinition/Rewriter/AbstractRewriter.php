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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter;

use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * AbstractRewriter.
 */
abstract class AbstractRewriter implements RewriterInterface
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @var string
     */
    private $extensionConfigurationKey = '';

    /**
     * @inheritDoc
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Setter: configuration.
     *
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @inheritDoc
     */
    public function getExtensionConfigurationKey()
    {
        return $this->extensionConfigurationKey;
    }

    /**
     * @inheritDoc
     */
    public function setExtensionConfigurationKey($extensionConfigKey)
    {
        $this->extensionConfigurationKey = $extensionConfigKey;
    }
}
