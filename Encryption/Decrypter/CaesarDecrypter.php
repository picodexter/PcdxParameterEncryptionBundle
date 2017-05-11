<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Decrypter;

use Picodexter\ParameterEncryptionBundle\Encryption\CaesarCipherInterface;

/**
 * CaesarDecrypter.
 */
class CaesarDecrypter implements DecrypterInterface
{
    /**
     * @var CaesarCipherInterface
     */
    private $cipher;

    /**
     * @var int
     */
    private $rotationAmount;

    /**
     * Constructor.
     *
     * @param CaesarCipherInterface $cipher
     * @param int                   $encrypterRotationAmount Rotation amount from encrypter.
     *                                                       Automatically gets reversed for decryption.
     */
    public function __construct(CaesarCipherInterface $cipher, $encrypterRotationAmount = 13)
    {
        $this->cipher = $cipher;
        $this->rotationAmount = (int) $encrypterRotationAmount * -1;
    }

    /**
     * @inheritDoc
     */
    public function decryptValue($encryptedValue)
    {
        return $this->cipher->apply($encryptedValue, $this->rotationAmount);
    }
}
