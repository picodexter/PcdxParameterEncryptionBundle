<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\StaticKeyType;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('pcdx_parameter_encryption');

        $rootNode
            ->fixXmlConfig('algorithm')
            ->children()
                ->arrayNode('algorithms')
                    ->info('Configure algorithms.')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('id')
                                ->info('Algorithm ID.')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('pattern')
                                ->info('Configure pattern.')
                                ->isRequired()
                                ->fixXmlConfig('argument')
                                ->children()
                                    ->scalarNode('type')
                                        ->info(
                                            'Pattern type to recognize a value to replace with this algorithm.'
                                            .' (Default = value_prefix)'
                                        )
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->arrayNode('arguments')
                                        ->info('Additional arguments to pass to the pattern type.')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->append($this->addCryptoNode('encrypt'))
                            ->append($this->addCryptoNode('decrypt'))
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * Add crypto node.
     *
     * @param string $type 'encrypt' or 'decrypt'
     *
     * @return NodeDefinition
     */
    public function addCryptoNode($type)
    {
        $builder = new TreeBuilder();
        $node = $builder->root($type.'ion');

        $node
            ->info('Configure '.$type.'er.')
            ->isRequired()
            ->fixXmlConfig('argument')
            ->children()
                ->scalarNode('service')
                    ->info('Symfony service name of '.$type.'er.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('key')
                    ->info(ucfirst($type).'ion key settings.')
                    ->beforeNormalization()
                        ->ifTrue(function ($v) {
                            return \is_string($v);
                        })
                        ->then(function ($v) {
                            return ['value' => $v];
                        })
                    ->end()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('value')
                            ->info('Either the key or a password to use for key generation.')
                            ->defaultValue('')
                        ->end()
                        ->booleanNode('base64_encoded')
                            ->info('Key / password (value) is base64 encoded.')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('type')
                            ->info('Key type.')
                            ->cannotBeEmpty()
                            ->defaultValue(StaticKeyType::TYPE_NAME)
                        ->end()
                        ->scalarNode('method')
                            ->info('Generated key: generation method.')
                            ->cannotBeEmpty()
                            ->defaultValue('pbkdf2')
                        ->end()
                        ->scalarNode('hash_algorithm')
                            ->info('Generated key: hash algorithm.')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('salt')
                            ->info('Generated key: salt.')
                            ->cannotBeEmpty()
                        ->end()
                        ->integerNode('cost')
                            ->info('Generated key: cost.')
                            ->min(1)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $node;
    }
}
