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
                                ->children()
                                    ->scalarNode('type')
                                        ->info(
                                            'Pattern type to recognize a value to replace with this algorithm.'
                                            . ' (Default = value_prefix)'
                                        )
                                        ->defaultValue('value_prefix')
                                    ->end()
                                    ->arrayNode('arguments')
                                        ->info('Additional arguments to pass to the pattern type.')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('encryption')
                                ->info('Configure encrypter.')
                                ->isRequired()
                                ->children()
                                    ->scalarNode('service')
                                        ->info('Symfony service name of encrypter.')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->scalarNode('key')
                                        ->info('Encryption key.')
                                        ->defaultNull()
                                    ->end()
                                    ->arrayNode('arguments')
                                        ->info('Additional arguments to pass to the encrypter.')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('decryption')
                                ->info('Configure decrypter.')
                                ->isRequired()
                                ->children()
                                    ->scalarNode('service')
                                        ->info('Symfony service name of decrypter.')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->scalarNode('key')
                                        ->info('Decryption key.')
                                        ->defaultNull()
                                    ->end()
                                    ->arrayNode('arguments')
                                        ->info('Additional arguments to pass to the decrypter.')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}