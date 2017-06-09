<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmConfigurationException;

/**
 * ServiceNameGenerator.
 */
class ServiceNameGenerator implements ServiceNameGeneratorInterface
{
    /**
     * Assert that algorithm configuration is valid.
     *
     * @param array $algorithmConfig
     */
    private function assertValidAlgorithmConfig(array $algorithmConfig)
    {
        if (!array_key_exists('id', $algorithmConfig) || !is_string($algorithmConfig['id'])) {
            throw new InvalidAlgorithmConfigurationException();
        }
    }

    /**
     * @inheritDoc
     */
    public function getAlgorithmConfigurationServiceNameForAlgorithm(array $algorithmConfig)
    {
        $this->assertValidAlgorithmConfig($algorithmConfig);

        return ServiceNames::ALGORITHM_CONFIGURATION_PREFIX.$algorithmConfig['id'];
    }

    /**
     * @inheritDoc
     */
    public function getReplacementPatternServiceNameForAlgorithm(array $algorithmConfig)
    {
        $this->assertValidAlgorithmConfig($algorithmConfig);

        return ServiceNames::REPLACEMENT_PATTERN_ALGORITHM_PREFIX.$algorithmConfig['id'];
    }

    /**
     * @inheritDoc
     */
    public function getReplacementSourceDecrypterServiceNameForAlgorithm(array $algorithmConfig)
    {
        $this->assertValidAlgorithmConfig($algorithmConfig);

        return ServiceNames::REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX.$algorithmConfig['id'];
    }
}
