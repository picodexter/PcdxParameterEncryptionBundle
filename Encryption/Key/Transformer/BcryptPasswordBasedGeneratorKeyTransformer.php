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

/**
 * BcryptPasswordBasedGeneratorKeyTransformer.
 */
class BcryptPasswordBasedGeneratorKeyTransformer implements KeyTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function appliesFor($key, KeyConfiguration $keyConfig)
    {
        return (($keyConfig->getType() instanceof GeneratedKeyType) && ('bcrypt' === $keyConfig->getMethod()));
    }

    /**
     * @inheritDoc
     */
    public function transform($key, KeyConfiguration $keyConfig)
    {
        $this->assertValidKeyConfiguration($keyConfig);

        $generatedKey = password_hash($key, PASSWORD_BCRYPT, [
            'salt' => $keyConfig->getSalt(),
            'cost' => $keyConfig->getCost(),
        ]);

        return $generatedKey;
    }

    /**
     * Assert that key configuration is valid.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @throws InvalidKeyConfigurationException
     */
    private function assertValidKeyConfiguration(KeyConfiguration $keyConfig)
    {
        if (empty($keyConfig->getSalt()) || empty($keyConfig->getCost())) {
            throw new InvalidKeyConfigurationException();
        }
    }
}
