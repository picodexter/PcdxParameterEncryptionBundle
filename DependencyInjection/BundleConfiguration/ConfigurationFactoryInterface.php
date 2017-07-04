<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration;

use Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection\InvalidConfigurationClassException;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * ConfigurationFactoryInterface.
 */
interface ConfigurationFactoryInterface
{
    /**
     * Create configuration.
     *
     * @param string $className
     * @param array  $arguments
     *
     * @throws InvalidConfigurationClassException
     *
     * @return ConfigurationInterface
     */
    public function createConfiguration($className, array $arguments = []);
}
