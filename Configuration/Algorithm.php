<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration;

use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\InvalidAlgorithmIdException;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

/**
 * Algorithm.
 */
class Algorithm
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var DecrypterInterface
     */
    private $decrypter;

    /**
     * @var EncrypterInterface
     */
    private $encrypter;

    /**
     * @var string|null
     */
    private $encryptionKey;

    /**
     * @var ReplacementPatternInterface
     */
    private $replacementPattern;

    /**
     * Constructor.
     *
     * @param string                      $id
     * @param DecrypterInterface          $decrypter
     * @param EncrypterInterface          $encrypter
     * @param string|null                 $encryptionKey
     * @param ReplacementPatternInterface $replacementPattern
     * @throws InvalidAlgorithmIdException
     */
    public function __construct(
        $id,
        DecrypterInterface $decrypter,
        EncrypterInterface $encrypter,
        $encryptionKey,
        ReplacementPatternInterface $replacementPattern
    ) {
        $this->setId($id);
        $this->decrypter = $decrypter;
        $this->encrypter = $encrypter;
        $this->encryptionKey = $encryptionKey;
        $this->replacementPattern = $replacementPattern;
    }

    /**
     * Getter: id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter: id.
     *
     * @param string $id
     * @throws InvalidAlgorithmIdException
     */
    public function setId($id)
    {
        $id = (string) $id;

        if (!preg_match('#^[a-zA-Z0-9_.]+$#', $id)) {
            throw new InvalidAlgorithmIdException($id);
        }

        $this->id = mb_strtolower($id);
    }

    /**
     * Getter: decrypter.
     *
     * @return DecrypterInterface
     */
    public function getDecrypter()
    {
        return $this->decrypter;
    }

    /**
     * Setter: decrypter.
     *
     * @param DecrypterInterface $decrypter
     */
    public function setDecrypter(DecrypterInterface $decrypter)
    {
        $this->decrypter = $decrypter;
    }

    /**
     * Getter: encrypter.
     *
     * @return EncrypterInterface
     */
    public function getEncrypter()
    {
        return $this->encrypter;
    }

    /**
     * Setter: encrypter.
     *
     * @param EncrypterInterface $encrypter
     */
    public function setEncrypter(EncrypterInterface $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    /**
     * Getter: encryptionKey.
     *
     * @return string|null
     */
    public function getEncryptionKey()
    {
        return $this->encryptionKey;
    }

    /**
     * Setter: encryptionKey.
     *
     * @param string|null $encryptionKey
     */
    public function setEncryptionKey($encryptionKey)
    {
        $this->encryptionKey = $encryptionKey;
    }

    /**
     * Getter: replacementPattern.
     *
     * @return ReplacementPatternInterface
     */
    public function getReplacementPattern()
    {
        return $this->replacementPattern;
    }

    /**
     * Setter: replacementPattern.
     *
     * @param ReplacementPatternInterface $replacementPattern
     */
    public function setReplacementPattern(ReplacementPatternInterface $replacementPattern)
    {
        $this->replacementPattern = $replacementPattern;
    }
}
