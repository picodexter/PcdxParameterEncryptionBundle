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
     * Constructor.
     *
     * @param CaesarCipherInterface $cipher
     */
    public function __construct(CaesarCipherInterface $cipher)
    {
        $this->cipher = $cipher;
    }

    /**
     * @inheritDoc
     */
    public function decryptValue($encryptedValue, $rotationAmount = 13)
    {
        $rotationAmount = (int) $rotationAmount * -1;

        return $this->cipher->apply($encryptedValue, $rotationAmount);
    }
}
