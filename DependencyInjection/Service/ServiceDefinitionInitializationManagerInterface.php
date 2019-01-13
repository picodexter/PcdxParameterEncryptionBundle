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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ServiceDefinitionInitializationManagerInterface.
 */
interface ServiceDefinitionInitializationManagerInterface
{
    /**
     * Initialize service definitions.
     *
     * @param array            $bundleConfig
     * @param ContainerBuilder $container
     */
    public function initializeServiceDefinitions(array $bundleConfig, ContainerBuilder $container);
}
