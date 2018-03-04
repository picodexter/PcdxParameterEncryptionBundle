<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter;

use Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;

/**
 * EnvironmentPlaceholderResolverFactory.
 */
class EnvironmentPlaceholderResolverFactory
{
    /**
     * Create environment placeholder resolver.
     *
     * @param string $classNameToCheck
     *
     * @return EnvironmentPlaceholderResolverInterface
     */
    public static function createResolver($classNameToCheck = EnvPlaceholderParameterBag::class)
    {
        if (class_exists($classNameToCheck)) {
            return new EnvironmentPlaceholderResolver();
        }

        return new LegacyEnvironmentPlaceholderResolver();
    }
}
