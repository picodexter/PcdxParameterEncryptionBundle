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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\ArgumentReplacerInterface;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Definition;

/**
 * DoctrineRewriter.
 */
class DoctrineRewriter extends AbstractRewriter
{
    /**
     * @var ArgumentReplacerInterface
     */
    private $argumentReplacer;

    /**
     * Constructor.
     *
     * @param ArgumentReplacerInterface $argumentReplacer
     * @param ConfigurationInterface    $configuration
     */
    public function __construct(ArgumentReplacerInterface $argumentReplacer, ConfigurationInterface $configuration)
    {
        $this->argumentReplacer = $argumentReplacer;
        $this->setConfiguration($configuration);
    }

    /**
     * @inheritDoc
     */
    public function applies($serviceId, Definition $definition, array $extensionConfig)
    {
        return ((0 === mb_strpos($serviceId, 'doctrine.dbal.'))
            && ((mb_strlen($serviceId) - 11) === mb_strpos($serviceId, '_connection'))
            && (mb_strlen($serviceId) > (mb_strlen('doctrine.dbal.') + mb_strlen('_connection'))));
    }

    /**
     * @inheritDoc
     */
    public function processServiceDefinition(
        $serviceId,
        Definition $definition,
        array $extensionConfig
    ) {
        preg_match('#^doctrine\.dbal\.(?P<connection_name>(.+))_connection$#', $serviceId, $match);

        $connectionName = $match['connection_name'];
        $resolvedConnConfig = $extensionConfig['dbal']['connections'][$connectionName];

        $arguments = $definition->getArguments();

        $this->processMainConfiguration($arguments[0], $resolvedConnConfig);

        $this->processSlaveConfigurationsIfExist($arguments[0], $resolvedConnConfig);

        $this->processShardConfigurationsIfExist($arguments[0], $resolvedConnConfig);

        $definition->setArguments($arguments);
    }

    /**
     * Process main configuration for this connection.
     *
     * @param array $serviceConnArguments
     * @param array $resolvedConnConfig
     */
    private function processMainConfiguration(array &$serviceConnArguments, $resolvedConnConfig)
    {
        if (array_key_exists('master', $serviceConnArguments)) {
            $this->replaceConnectionArguments($serviceConnArguments['master'], $resolvedConnConfig);
        } elseif (array_key_exists('global', $serviceConnArguments)) {
            $this->replaceConnectionArguments($serviceConnArguments['global'], $resolvedConnConfig);
        } else {
            $this->replaceConnectionArguments($serviceConnArguments, $resolvedConnConfig);
        }
    }

    /**
     * Process shard configurations if they exist.
     *
     * @param array $serviceConnArguments
     * @param array $resolvedConnConfig
     */
    private function processShardConfigurationsIfExist(array &$serviceConnArguments, array $resolvedConnConfig)
    {
        if (array_key_exists('shards', $serviceConnArguments)) {
            foreach ($serviceConnArguments['shards'] as $shardName => &$shardConfig) {
                $this->replaceConnectionArguments($shardConfig, $resolvedConnConfig['shards'][$shardName]);
            }
        }
    }

    /**
     * Process slave configurations if they exist.
     *
     * @param array $serviceConnArguments
     * @param array $resolvedConnConfig
     */
    private function processSlaveConfigurationsIfExist(array &$serviceConnArguments, array $resolvedConnConfig)
    {
        if (array_key_exists('slaves', $serviceConnArguments)) {
            foreach ($serviceConnArguments['slaves'] as $slaveName => &$slaveConfig) {
                $this->replaceConnectionArguments($slaveConfig, $resolvedConnConfig['slaves'][$slaveName]);
            }
        }
    }

    /**
     * Replace connection arguments.
     *
     * @param array $serviceConnArguments
     * @param array $resolvedConnConfig
     */
    private function replaceConnectionArguments(array &$serviceConnArguments, array $resolvedConnConfig)
    {
        $serviceConnArguments = $this->argumentReplacer
            ->replaceArgumentIfExists($serviceConnArguments, $resolvedConnConfig, 'host');
        $serviceConnArguments = $this->argumentReplacer
            ->replaceArgumentIfExists($serviceConnArguments, $resolvedConnConfig, 'port');
        $serviceConnArguments = $this->argumentReplacer
            ->replaceArgumentIfExists($serviceConnArguments, $resolvedConnConfig, 'dbname');
        $serviceConnArguments = $this->argumentReplacer
            ->replaceArgumentIfExists($serviceConnArguments, $resolvedConnConfig, 'user');
        $serviceConnArguments = $this->argumentReplacer
            ->replaceArgumentIfExists($serviceConnArguments, $resolvedConnConfig, 'password');
        $serviceConnArguments = $this->argumentReplacer
            ->replaceArgumentIfExists($serviceConnArguments, $resolvedConnConfig, 'url');
    }
}
