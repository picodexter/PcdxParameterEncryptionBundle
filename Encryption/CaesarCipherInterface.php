<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption;

/**
 * CaesarCipherInterface.
 */
interface CaesarCipherInterface
{
    /**
     * Apply Caesar cipher.
     *
     * @param string $inputText
     * @param int    $rotationAmount
     * @return string
     */
    public function apply($inputText, $rotationAmount);
}
