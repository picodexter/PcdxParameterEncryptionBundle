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

namespace Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding;

use Picodexter\ParameterEncryptionBundle\Exception\Encryption\InvalidBase64ValueException;

/**
 * DecoderInterface.
 */
interface DecoderInterface
{
    /**
     * Decode a Base64 encoded value.
     *
     * @param string $encodedValue
     *
     * @throws InvalidBase64ValueException
     *
     * @return string
     */
    public function decode($encodedValue);
}
