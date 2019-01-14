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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler;

use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\UnknownReplacementPatternTypeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ReplacementPatternRegistrationHandlerInterface.
 */
interface ReplacementPatternRegistrationHandlerInterface
{
    /**
     * Register replacement patterns.
     *
     * @param array            $bundleConfig
     * @param ContainerBuilder $container
     *
     * @throws InvalidBundleConfigurationException
     * @throws UnknownReplacementPatternTypeException
     */
    public function registerReplacementPatterns(array $bundleConfig, ContainerBuilder $container);
}
