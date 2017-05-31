<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding;

use Picodexter\ParameterEncryptionBundle\Exception\Encryption\InvalidBase64ValueException;

/**
 * Base64Decoder.
 */
class Base64Decoder implements DecoderInterface
{
    /**
     * @inheritDoc
     */
    public function decode($encodedValue)
    {
        $decodedValue = base64_decode((string) $encodedValue, true);

        if (false === $decodedValue) {
            throw new InvalidBase64ValueException();
        }

        return $decodedValue;
    }
}
