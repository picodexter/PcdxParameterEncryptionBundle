<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration\Key;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\KeyTypeRegistryInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidKeyTypeException;

/**
 * KeyConfigurationFactory.
 */
class KeyConfigurationFactory implements KeyConfigurationFactoryInterface
{
    /**
     * @var KeyTypeRegistryInterface
     */
    private $keyTypeRegistry;

    /**
     * Constructor.
     *
     * @param KeyTypeRegistryInterface $keyTypeRegistry
     */
    public function __construct(KeyTypeRegistryInterface $keyTypeRegistry)
    {
        $this->keyTypeRegistry = $keyTypeRegistry;
    }

    /**
     * @inheritDoc
     */
    public function createKeyConfiguration(array $keyConfig)
    {
        $keyConfiguration = new KeyConfiguration();

        if (key_exists('cost', $keyConfig)) {
            $keyConfiguration->setCost($keyConfig['cost']);
        }

        if (key_exists('hash_algorithm', $keyConfig)) {
            $keyConfiguration->setHashAlgorithm($keyConfig['hash_algorithm']);
        }

        if (key_exists('method', $keyConfig)) {
            $keyConfiguration->setMethod($keyConfig['method']);
        }

        if (key_exists('salt', $keyConfig)) {
            $keyConfiguration->setSalt($keyConfig['salt']);
        }

        if (key_exists('type', $keyConfig)) {
            $this->assertValidKeyType($keyConfig['type']);

            $keyConfiguration->setType($keyConfig['type']);
        }

        if (key_exists('value', $keyConfig)) {
            $keyConfiguration->setValue($keyConfig['value']);
        }

        return $keyConfiguration;
    }

    /**
     * Assert that the key type is valid.
     *
     * @param string $keyTypeName
     *
     * @throws InvalidKeyTypeException
     */
    private function assertValidKeyType($keyTypeName)
    {
        if (!$this->keyTypeRegistry->has($keyTypeName)) {
            throw new InvalidKeyTypeException($keyTypeName);
        }
    }
}
