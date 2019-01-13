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
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ReplacementPatternInjectionHandlerInterface.
 */
interface ReplacementPatternInjectionHandlerInterface
{
    /**
     * Inject replacement patterns into replacement pattern registry.
     *
     * @param array            $bundleConfig
     * @param ContainerBuilder $container
     *
     * @throws InvalidBundleConfigurationException
     */
    public function injectReplacementPatternsIntoRegistry(array $bundleConfig, ContainerBuilder $container);
}
