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

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
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
     * @var KeyConfiguration
     */
    private $decryptionKeyConfig;

    /**
     * @var EncrypterInterface
     */
    private $encrypter;

    /**
     * @var string
     */
    private $encrypterServiceName;

    /**
     * @var KeyConfiguration
     */
    private $encryptionKeyConfig;

    /**
     * @var ReplacementPatternInterface
     */
    private $replacementPattern;

    /**
     * Constructor.
     *
     * @param string             $id
     * @param DecrypterInterface $decrypter
     * @param string             $decrypterServiceName
     * @param KeyConfiguration   $decryptionKeyConfig
     * @param EncrypterInterface $encrypter
     * @param string             $encrypterServiceName
     * @param KeyConfiguration   $encryptionKeyConfig
     * @param ReplacementPatternInterface $replacementPattern
     *
     * @throws InvalidAlgorithmIdException
     */
    public function __construct(
        $id,
        DecrypterInterface $decrypter,
        $decrypterServiceName,
        KeyConfiguration $decryptionKeyConfig,
        EncrypterInterface $encrypter,
        $encrypterServiceName,
        KeyConfiguration $encryptionKeyConfig,
        ReplacementPatternInterface $replacementPattern
    ) {
        $this->setId($id);
        $this->decrypter = $decrypter;
        $this->decrypterServiceName = $decrypterServiceName;
        $this->decryptionKeyConfig = $decryptionKeyConfig;
        $this->encrypter = $encrypter;
        $this->encrypterServiceName = $encrypterServiceName;
        $this->encryptionKeyConfig = $encryptionKeyConfig;
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
     *
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
     * Getter: decryptionKeyConfig.
     *
     * @return KeyConfiguration
     */
    public function getDecryptionKeyConfig()
    {
        return $this->decryptionKeyConfig;
    }

    /**
     * Setter: decryptionKeyConfig.
     *
     * @param KeyConfiguration $decryptionKeyConfig
     */
    public function setDecryptionKeyConfig(KeyConfiguration $decryptionKeyConfig)
    {
        $this->decryptionKeyConfig = $decryptionKeyConfig;
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
     * Getter: encryptionKeyConfig.
     *
     * @return KeyConfiguration
     */
    public function getEncryptionKeyConfig()
    {
        return $this->encryptionKeyConfig;
    }

    /**
     * Setter: encryptionKeyConfig.
     *
     * @param KeyConfiguration $encryptionKeyConfig
     */
    public function setEncryptionKeyConfig(KeyConfiguration $encryptionKeyConfig)
    {
        $this->encryptionKeyConfig = $encryptionKeyConfig;
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
