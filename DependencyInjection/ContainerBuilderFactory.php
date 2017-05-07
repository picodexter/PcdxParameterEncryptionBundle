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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * ContainerBuilderFactory.
 */
class ContainerBuilderFactory
{
    /**
     * Create a ContainerBuilder.
     *
     * @return ContainerBuilder
     */
    public static function createContainerBuilder()
    {
        $containerBuilder = new ContainerBuilder();

        $loader = new XmlFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services_compilerpass.xml');

        return $containerBuilder;
    }
}
