<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\Decorator;

use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyNotEmptyValidatorInterface;

/**
 * KeyNotEmptyEncrypterDecorator.
 */
class KeyNotEmptyEncrypterDecorator implements EncrypterInterface
{
    /**
     * @var EncrypterInterface
     */
    private $encrypter;

    /**
     * @var KeyNotEmptyValidatorInterface
     */
    private $keyNotEmptyValidator;

    /**
     * Constructor.
     *
     * @param EncrypterInterface            $encrypter
     * @param KeyNotEmptyValidatorInterface $keyNotEmptyValidator
     */
    public function __construct(EncrypterInterface $encrypter, KeyNotEmptyValidatorInterface $keyNotEmptyValidator)
    {
        $this->encrypter = $encrypter;
        $this->keyNotEmptyValidator = $keyNotEmptyValidator;
    }

    /**
     * @inheritDoc
     */
    public function encryptValue($plainValue, $encryptionKey)
    {
        $this->keyNotEmptyValidator->assertKeyNotEmpty($encryptionKey);

        return $this->encrypter->encryptValue($plainValue, $encryptionKey);
    }
}
