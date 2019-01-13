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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * LegacyEnvironmentPlaceholderResolver.
 *
 * Compatibility layer for Symfony < 3.2 which did not support environment placeholders.
 */
class LegacyEnvironmentPlaceholderResolver implements EnvironmentPlaceholderResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolveEnvironmentPlaceholders($parameterValue, ContainerBuilder $container)
    {
        return $parameterValue;
    }
}
