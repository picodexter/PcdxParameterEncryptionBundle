<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * InitializerInterface.
 */
interface InitializerInterface
{
    /**
     * Initialize service definitions.
     *
     * @param array            $bundleConfig
     * @param ContainerBuilder $container
     */
    public function initialize(array $bundleConfig, ContainerBuilder $container);
}