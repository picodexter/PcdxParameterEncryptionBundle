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

use Picodexter\ParameterEncryptionBundle\Exception\InvalidAlgorithmConfigurationException;

/**
 * ServiceNameGeneratorInterface.
 */
interface ServiceNameGeneratorInterface
{
    /**
     * Get name of replacement pattern service for algorithm.
     *
     * @param array $algorithmConfig
     * @return string
     * @throws InvalidAlgorithmConfigurationException
     */
    public function getReplacementPatternServiceNameForAlgorithm(array $algorithmConfig);

    /**
     * Get name of replacement source decrypter service for algorithm.
     *
     * @param array $algorithmConfig
     * @return string
     * @throws InvalidAlgorithmConfigurationException
     */
    public function getReplacementSourceDecrypterServiceNameForAlgorithm(array $algorithmConfig);

    /**
     * Get name of algorithm service for algorithm.
     *
     * @param array $algorithmConfig
     * @return string
     * @throws InvalidAlgorithmConfigurationException
     */
    public function getServiceNameForAlgorithm(array $algorithmConfig);
}
