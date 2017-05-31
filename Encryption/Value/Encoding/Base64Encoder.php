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

/**
 * Base64Encoder.
 */
class Base64Encoder implements EncoderInterface
{
    /**
     * @inheritDoc
     */
    public function encode($plainValue)
    {
        return base64_encode((string) $plainValue);
    }
}
