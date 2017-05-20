<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * BundleServiceDefinitionsLoaderInterface.
 */
interface BundleServiceDefinitionsLoaderInterface
{
    /**
     * Load bundle service definitions.
     *
     * @param ContainerBuilder $container
     */
    public function loadBundleServiceDefinitions(ContainerBuilder $container);
}
