<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler;

use Picodexter\ParameterEncryptionBundle\Exception\InvalidBundleConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * AlgorithmInjectionHandlerInterface.
 */
interface AlgorithmInjectionHandlerInterface
{
    /**
     * Inject algorithm configurations into algorithm configuration container.
     *
     * @param array            $bundleConfig
     * @param ContainerBuilder $container
     * @throws InvalidBundleConfigurationException
     */
    public function injectAlgorithmConfigurationsIntoContainer(array $bundleConfig, ContainerBuilder $container);
}
