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

use Picodexter\ParameterEncryptionBundle\Exception\Encryption\DecrypterException;

/**
 * DecrypterInterface.
 */
interface DecrypterInterface
{
    /**
     * Decrypt value.
     *
     * @param string      $encryptedValue
     * @param string|null $decryptionKey
     *
     * @return string
     *
     * @throws DecrypterException
     */
    public function decryptValue($encryptedValue, $decryptionKey = null);
}
