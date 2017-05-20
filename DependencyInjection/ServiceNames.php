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
    const ALGORITHM_CONFIGURATION_CONTAINER
        = 'pcdx_parameter_encryption.configuration.algorithm_configuration_container';
    const ALGORITHM_CONFIGURATION_PREFIX = 'pcdx_parameter_encryption.configuration.algorithm_configuration.';
    const PARAMETER_REPLACER = 'pcdx_parameter_encryption.replacement.parameter_replacer';
    const PARAMETER_REPLACEMENT_FETCHER = 'pcdx_parameter_encryption.replacement.parameter_replacement_fetcher';
    const REPLACEMENT_PATTERN_ALGORITHM_PREFIX = 'pcdx_parameter_encryption.replacement.pattern.algorithm.';
    const REPLACEMENT_PATTERN_REGISTRY = 'pcdx_parameter_encryption.replacement.pattern.registry';
    const REPLACEMENT_PATTERN_TYPE_REGISTRY = 'pcdx_parameter_encryption.replacement.pattern.type_registry';
    const REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX = 'pcdx_parameter_encryption.replacement.source.decrypter.';
    const SERVICE_DEFINITION_INITIALIZATION_MANAGER
        = 'pcdx_parameter_encryption.dependency_injection.service.definition_initialization_manager';

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
