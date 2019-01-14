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

namespace Picodexter\ParameterEncryptionBundle\Encryption\Encrypter;

use Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException;
use Picodexter\ParameterEncryptionBundle\Exception\Encryption\EncrypterException;

/**
 * EncrypterInterface.
 */
interface EncrypterInterface
{
    /**
     * Encrypt value.
     *
     * @param string $plainValue
     * @param string $encryptionKey
     *
     * @throws EmptyKeyException
     * @throws EncrypterException
     *
     * @return string
     */
    public function encryptValue($plainValue, $encryptionKey);
}
