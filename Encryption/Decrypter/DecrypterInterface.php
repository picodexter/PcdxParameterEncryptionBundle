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

namespace Picodexter\ParameterEncryptionBundle\Encryption\Decrypter;

use Picodexter\ParameterEncryptionBundle\Exception\Encryption\DecrypterException;
use Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException;

/**
 * DecrypterInterface.
 */
interface DecrypterInterface
{
    /**
     * Decrypt value.
     *
     * @param string $encryptedValue
     * @param string $decryptionKey
     *
     * @throws DecrypterException
     * @throws EmptyKeyException
     *
     * @return string|null
     */
    public function decryptValue($encryptedValue, $decryptionKey);
}
