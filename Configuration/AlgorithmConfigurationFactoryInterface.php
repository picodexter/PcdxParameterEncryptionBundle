<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration;

use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmConfigurationException;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

/**
 * AlgorithmConfigurationFactoryInterface.
 */
interface AlgorithmConfigurationFactoryInterface
{
    /**
     * Create algorithm configuration.
     *
     * @param array                       $algorithmConfig
     * @param DecrypterInterface          $decrypter
     * @param EncrypterInterface          $encrypter
     * @param ReplacementPatternInterface $replacementPattern
     *
     * @throws InvalidAlgorithmConfigurationException
     *
     * @return AlgorithmConfiguration
     */
    public function createAlgorithmConfiguration(
        array $algorithmConfig,
        DecrypterInterface $decrypter,
        EncrypterInterface $encrypter,
        ReplacementPatternInterface $replacementPattern
    );
}
