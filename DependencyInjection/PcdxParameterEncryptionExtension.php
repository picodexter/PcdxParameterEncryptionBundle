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
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * PcdxParameterEncryptionExtension.
 */
class PcdxParameterEncryptionExtension extends ConfigurableExtension
{
    /**
     * Initialize service definitions.
     *
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    private function initializeServiceDefinitions(array $mergedConfig, ContainerBuilder $container)
    {
        $definitionManager = $container->get(ServiceNames::SERVICE_DEFINITION_INITIALIZATION_MANAGER);
        $definitionManager->initializeServiceDefinitions($mergedConfig, $container);
    }

    /**
     * @inheritDoc
     */
    public function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $this->initializeServiceDefinitions($mergedConfig, $container);
    }
}
