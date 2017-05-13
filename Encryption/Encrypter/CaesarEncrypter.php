<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Encrypter;

use Picodexter\ParameterEncryptionBundle\Encryption\CaesarCipherInterface;

/**
 * CaesarEncrypter.
 */
class CaesarEncrypter implements EncrypterInterface
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
     * @param int                   $rotationAmount
     */
    public function __construct(CaesarCipherInterface $cipher, $rotationAmount = 13)
    {
        $this->cipher = $cipher;
        $this->rotationAmount = (int) $rotationAmount;
    }

    /**
     * @inheritDoc
     */
    public function encryptValue($plainValue, $encryptionKey = null)
    {
        return $this->cipher->apply($plainValue, $this->rotationAmount);
    }
}
