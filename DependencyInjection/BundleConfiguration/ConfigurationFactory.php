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
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * ConfigurationFactory.
 */
class ConfigurationFactory implements ConfigurationFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createConfiguration($className, array $arguments = [])
    {
        try {
            $reflectionClass = new ReflectionClass($className);
        } catch (ReflectionException $e) {
            throw new InvalidConfigurationClassException($className);
        }

        if (!in_array(ConfigurationInterface::class, $reflectionClass->getInterfaceNames(), true)) {
            throw new InvalidConfigurationClassException($className);
        }

        $configuration = $reflectionClass->newInstanceArgs($arguments);

        return $configuration;
    }
}
