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
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmIdException;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

/**
 * AlgorithmConfiguration.
 */
class AlgorithmConfiguration
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
     * @var string
     */
    private $decrypterServiceName;

    /**
     * @var string|null
     */
    private $decryptionKey;

    /**
     * @var EncrypterInterface
     */
    private $encrypter;

    /**
     * @var string
     */
    private $encrypterServiceName;

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
     * @param string                      $decrypterServiceName
     * @param string|null                 $decryptionKey
     * @param EncrypterInterface          $encrypter
     * @param string                      $encrypterServiceName
     * @param string|null                 $encryptionKey
     * @param ReplacementPatternInterface $replacementPattern
     * @throws InvalidAlgorithmIdException
     */
    public function __construct(
        $id,
        DecrypterInterface $decrypter,
        $decrypterServiceName,
        $decryptionKey,
        EncrypterInterface $encrypter,
        $encrypterServiceName,
        $encryptionKey,
        ReplacementPatternInterface $replacementPattern
    ) {
        $this->setId($id);
        $this->decrypter = $decrypter;
        $this->decrypterServiceName = $decrypterServiceName;
        $this->decryptionKey = $decryptionKey;
        $this->encrypter = $encrypter;
        $this->encrypterServiceName = $encrypterServiceName;
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
     * Getter: decrypterServiceName.
     *
     * @return string
     */
    public function getDecrypterServiceName()
    {
        return $this->decrypterServiceName;
    }

    /**
     * Setter: decrypterServiceName.
     *
     * @param string $decrypterServiceName
     */
    public function setDecrypterServiceName($decrypterServiceName)
    {
        $this->decrypterServiceName = $decrypterServiceName;
    }

    /**
     * Getter: decryptionKey.
     *
     * @return string|null
     */
    public function getDecryptionKey()
    {
        return $this->decryptionKey;
    }

    /**
     * Setter: decryptionKey.
     *
     * @param string|null $decryptionKey
     */
    public function setDecryptionKey($decryptionKey)
    {
        $this->decryptionKey = $decryptionKey;
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
     * Getter: encrypterServiceName.
     *
     * @return string
     */
    public function getEncrypterServiceName()
    {
        return $this->encrypterServiceName;
    }

    /**
     * Setter: encrypterServiceName.
     *
     * @param string $encrypterServiceName
     */
    public function setEncrypterServiceName($encrypterServiceName)
    {
        $this->encrypterServiceName = $encrypterServiceName;
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
