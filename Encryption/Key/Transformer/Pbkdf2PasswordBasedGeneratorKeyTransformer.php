<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\GeneratedKeyType;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidKeyConfigurationException;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\UnknownHashAlgorithmException;

/**
 * Pbkdf2PasswordBasedGeneratorKeyTransformer.
 */
class Pbkdf2PasswordBasedGeneratorKeyTransformer implements KeyTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function appliesFor($key, KeyConfiguration $keyConfig)
    {
        return ($keyConfig->getType() instanceof GeneratedKeyType) && ('pbkdf2' === $keyConfig->getMethod());
    }

    /**
     * @inheritDoc
     */
    public function transform($key, KeyConfiguration $keyConfig)
    {
        $this->assertValidKeyConfiguration($keyConfig);

        $hashAlgorithm = $keyConfig->getHashAlgorithm();
        $salt = $keyConfig->getSalt();
        $cost = $keyConfig->getCost();

        $generatedKey = hash_pbkdf2($hashAlgorithm, $key, $salt, $cost, 0, true);

        return $generatedKey;
    }

    /**
     * Assert that hash algorithm is valid.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @throws UnknownHashAlgorithmException
     */
    private function assertValidHashAlgorithm(KeyConfiguration $keyConfig)
    {
        if (!in_array($keyConfig->getHashAlgorithm(), hash_algos(), true)) {
            throw new UnknownHashAlgorithmException($keyConfig->getHashAlgorithm());
        }
    }

    /**
     * Assert that key configuration is valid.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @throws InvalidKeyConfigurationException
     * @throws UnknownHashAlgorithmException
     */
    private function assertValidKeyConfiguration(KeyConfiguration $keyConfig)
    {
        if (empty($keyConfig->getHashAlgorithm()) || empty($keyConfig->getSalt()) || empty($keyConfig->getCost())) {
            throw new InvalidKeyConfigurationException();
        }

        $this->assertValidHashAlgorithm($keyConfig);
    }
}
