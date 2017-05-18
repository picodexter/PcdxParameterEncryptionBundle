<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\InvalidAlgorithmConfigurationException;

/**
 * AbstractInitializer.
 */
abstract class AbstractInitializer implements AlgorithmInitializerInterface
{
    /**
     * Get name of replacement pattern service for algorithm.
     *
     * @param array $algorithmConfig
     * @return string
     * @throws InvalidAlgorithmConfigurationException
     */
    public function getReplacementPatternServiceNameForAlgorithm(array $algorithmConfig)
    {
        if (!key_exists('id', $algorithmConfig) || !is_string($algorithmConfig['id'])) {
            throw new InvalidAlgorithmConfigurationException();
        }

        return ServiceNames::REPLACEMENT_PATTERN_ALGORITHM_PREFIX . $algorithmConfig['id'];
    }
}
