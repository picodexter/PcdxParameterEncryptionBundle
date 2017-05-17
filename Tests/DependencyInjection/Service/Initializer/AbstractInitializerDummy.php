<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Initializer;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\AbstractInitializer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * AbstractInitializerDummy.
 */
class AbstractInitializerDummy extends AbstractInitializer
{
    public function initialize(array $bundleConfig, ContainerBuilder $container)
    {
    }
}
