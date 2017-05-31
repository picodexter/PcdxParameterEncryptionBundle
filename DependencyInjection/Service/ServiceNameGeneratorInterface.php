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

use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmConfigurationException;

/**
 * ServiceNameGeneratorInterface.
 */
interface ServiceNameGeneratorInterface
{
    /**
     * Get name of algorithm configuration service for algorithm.
     *
     * @param array $algorithmConfig
     *
     * @throws InvalidAlgorithmConfigurationException
     *
     * @return string
     */
    public function getAlgorithmConfigurationServiceNameForAlgorithm(array $algorithmConfig);

    /**
     * Get name of replacement pattern service for algorithm.
     *
     * @param array $algorithmConfig
     *
     * @throws InvalidAlgorithmConfigurationException
     *
     * @return string
     */
    public function getReplacementPatternServiceNameForAlgorithm(array $algorithmConfig);

    /**
     * Get name of replacement source decrypter service for algorithm.
     *
     * @param array $algorithmConfig
     *
     * @throws InvalidAlgorithmConfigurationException
     *
     * @return string
     */
    public function getReplacementSourceDecrypterServiceNameForAlgorithm(array $algorithmConfig);
}
