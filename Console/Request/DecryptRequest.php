<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Request;

use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;

/**
 * DecryptRequest.
 */
class DecryptRequest
{
    /**
     * @var string
     */
    private $algorithmId;

    /**
     * @var QuestionAskerInterface
     */
    private $encryptedQuestionAsker;

    /**
     * @var string
     */
    private $encryptedValue;

    /**
     * @var string
     */
    private $key;

    /**
     * @var bool
     */
    private $keyProvided;

    /**
     * Constructor.
     *
     * @param string                 $algorithmId
     * @param QuestionAskerInterface $encryptedAsker
     * @param string                 $encryptedValue
     * @param string                 $key
     * @param bool                   $keyProvided
     */
    public function __construct(
        $algorithmId,
        QuestionAskerInterface $encryptedAsker,
        $encryptedValue,
        $key,
        $keyProvided
    ) {
        $this->algorithmId = $algorithmId;
        $this->encryptedQuestionAsker = $encryptedAsker;
        $this->encryptedValue = $encryptedValue;
        $this->key = $key;
        $this->keyProvided = (bool) $keyProvided;
    }

    /**
     * Getter: algorithmId.
     *
     * @return string
     */
    public function getAlgorithmId()
    {
        return $this->algorithmId;
    }

    /**
     * Getter: encryptedQuestionAsker.
     *
     * @return QuestionAskerInterface
     */
    public function getEncryptedQuestionAsker()
    {
        return $this->encryptedQuestionAsker;
    }

    /**
     * Getter: encryptedValue.
     *
     * @return string
     */
    public function getEncryptedValue()
    {
        return $this->encryptedValue;
    }

    /**
     * Getter: key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Getter: keyProvided.
     *
     * @return bool
     */
    public function isKeyProvided()
    {
        return $this->keyProvided;
    }
}
