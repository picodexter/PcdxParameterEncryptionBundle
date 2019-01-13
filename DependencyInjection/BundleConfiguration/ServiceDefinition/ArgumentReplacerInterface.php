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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition;

/**
 * ArgumentReplacerInterface.
 */
interface ArgumentReplacerInterface
{
    /**
     * Replace argument if key exists.
     *
     * Checks existence of key for both arguments and replacements.
     *
     * @param array  $arguments
     * @param array  $replacements
     * @param string $argumentKey
     */
    public function replaceArgumentIfExists(array $arguments, array $replacements, $argumentKey);
}
