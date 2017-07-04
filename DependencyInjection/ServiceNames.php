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
    const ALGORITHM_CONFIGURATION_FACTORY = 'pcdx_parameter_encryption.configuration.algorithm_configuration_factory';
    const ALGORITHM_CONFIGURATION_PREFIX = 'pcdx_parameter_encryption.configuration.algorithm_configuration.';
    const BUNDLE_CONFIGURATION_SERVICE_DEFINITION_PROCESSOR
        = 'pcdx_parameter_encryption.dependency_injection.bundle_configuration.service_definition.processor';
    const BUNDLE_CONFIGURATION_SERVICE_DEFINITION_REWRITER_REGISTRY
        = 'pcdx_parameter_encryption.dependency_injection.bundle_configuration.service_definition.rewriter.registry';
    const KEY_CONFIGURATION_FACTORY = 'pcdx_parameter_encryption.configuration.key.configuration_factory';
    const KEY_FETCHER = 'pcdx_parameter_encryption.encryption.key.fetcher';
    const KEY_VALIDATOR_NOT_EMPTY = 'pcdx_parameter_encryption.encryption.key.validator.not_empty';
    const PARAMETER_REPLACER = 'pcdx_parameter_encryption.replacement.parameter_replacer';
    const PARAMETER_REPLACEMENT_FETCHER = 'pcdx_parameter_encryption.replacement.parameter_replacement_fetcher';
    const REPLACEMENT_PATTERN_ALGORITHM_PREFIX = 'pcdx_parameter_encryption.replacement.pattern.algorithm.';
    const REPLACEMENT_PATTERN_REGISTRY = 'pcdx_parameter_encryption.replacement.pattern.registry';
    const REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX = 'pcdx_parameter_encryption.replacement.source.decrypter.';
    const SERVICE_DEFINITION_INITIALIZATION_MANAGER
        = 'pcdx_parameter_encryption.dependency_injection.service.definition_initialization_manager';
    const SERVICE_TAG_PROCESSOR_KEY_NOT_EMPTY
        = 'pcdx_parameter_encryption.dependency_injection.service.tag.processor.key_not_empty';

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
