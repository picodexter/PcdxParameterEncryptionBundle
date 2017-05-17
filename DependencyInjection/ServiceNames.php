<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection;

/**
 * ServiceNames.
 *
 * Contains names for this bundle's Symfony services that are referenced in the code.
 */
final class ServiceNames
{
    const PARAMETER_REPLACER = 'pcdx_parameter_encryption.replacement.parameter_replacer';
    const REPLACEMENT_PATTERN_ALGORITHM_PREFIX = 'pcdx_parameter_encryption.replacement.pattern.algorithm.';

    /**
     * Constructor.
     *
     * Forbid instantiation.
     */
    public function __construct()
    {
        throw new \BadMethodCallException('This class cannot be instantiated.');
    }
}
