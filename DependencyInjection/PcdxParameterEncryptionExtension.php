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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader\BundleServiceDefinitionsLoaderFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * PcdxParameterEncryptionExtension.
 */
class PcdxParameterEncryptionExtension extends ConfigurableExtension
{
    const XML_NAMESPACE = 'https://picodexter.io/schema/dic/pcdx_parameter_encryption';
    const XSD_VALIDATION_BASE_PATH = __DIR__ . '/../Resources/config/schema';

    /**
     * @inheritDoc
     */
    public function getNamespace()
    {
        return self::XML_NAMESPACE;
    }

    /**
     * @inheritDoc
     */
    public function getXsdValidationBasePath()
    {
        return self::XSD_VALIDATION_BASE_PATH;
    }

    /**
     * Initialize service definitions.
     *
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    private function initializeServiceDefinitions(array $mergedConfig, ContainerBuilder $container)
    {
        $initManager = $container->get(ServiceNames::SERVICE_DEFINITION_INITIALIZATION_MANAGER);
        $initManager->initializeServiceDefinitions($mergedConfig, $container);
    }

    /**
     * Load bundle service definitions.
     *
     * @param ContainerBuilder $container
     */
    private function loadBundleServiceDefinitions(ContainerBuilder $container)
    {
        $definitionsLoader = BundleServiceDefinitionsLoaderFactory::createBundleServiceDefinitionsLoader();
        $definitionsLoader->loadBundleServiceDefinitions($container);
    }

    /**
     * @inheritDoc
     */
    public function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $this->loadBundleServiceDefinitions($container);
        $this->initializeServiceDefinitions($mergedConfig, $container);
    }
}
