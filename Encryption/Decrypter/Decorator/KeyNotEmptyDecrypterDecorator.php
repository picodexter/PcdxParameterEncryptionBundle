<?php

declare(strict_types=1);

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\Decorator;

use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyNotEmptyValidatorInterface;

/**
 * KeyNotEmptyDecrypterDecorator.
 */
class KeyNotEmptyDecrypterDecorator implements DecrypterInterface
{
    /**
     * @var DecrypterInterface
     */
    private $decrypter;

    /**
     * @var KeyNotEmptyValidatorInterface
     */
    private $keyNotEmptyValidator;

    /**
     * Constructor.
     *
     * @param DecrypterInterface            $decrypter
     * @param KeyNotEmptyValidatorInterface $keyNotEmptyValidator
     */
    public function __construct(DecrypterInterface $decrypter, KeyNotEmptyValidatorInterface $keyNotEmptyValidator)
    {
        $this->decrypter = $decrypter;
        $this->keyNotEmptyValidator = $keyNotEmptyValidator;
    }

    /**
     * @inheritDoc
     */
    public function decryptValue($encryptedValue, $decryptionKey)
    {
        $this->keyNotEmptyValidator->assertKeyNotEmpty($decryptionKey);

        return $this->decrypter->decryptValue($encryptedValue, $decryptionKey);
    }
}
