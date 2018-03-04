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

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * EnvironmentPlaceholderResolverInterface.
 */
interface EnvironmentPlaceholderResolverInterface
{
    /**
     * Resolve environment placeholders.
     *
     * @param mixed            $parameterValue
     * @param ContainerBuilder $container
     *
     * @return mixed
     */
    public function resolveEnvironmentPlaceholders($parameterValue, ContainerBuilder $container);
}
