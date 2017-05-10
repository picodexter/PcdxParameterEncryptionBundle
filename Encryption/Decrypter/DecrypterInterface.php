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

/**
 * DecrypterInterface.
 */
interface DecrypterInterface
{
    /**
     * Decrypt value.
     *
     * @param string $encryptedValue
     * @param int    $encryptionRotationAmount Rotation amount from encrypter.
     *                                         Automatically gets reversed for decryption.
     * @return string
     */
    public function decryptValue($encryptedValue, $encryptionRotationAmount = 13);
}
