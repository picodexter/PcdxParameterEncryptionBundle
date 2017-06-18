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
 * EncryptRequest.
 */
class EncryptRequest
{
    /**
     * @var string
     */
    private $algorithmId;

    /**
     * @var string
     */
    private $key;

    /**
     * @var bool
     */
    private $keyProvided;

    /**
     * @var QuestionAskerInterface
     */
    private $plaintextQuestionAsker;

    /**
     * @var string
     */
    private $plaintextValue;

    /**
     * Constructor.
     *
     * @param string                 $algorithmId
     * @param string                 $key
     * @param bool                   $keyProvided
     * @param QuestionAskerInterface $plaintextAsker
     * @param string                 $plaintextValue
     */
    public function __construct(
        $algorithmId,
        $key,
        $keyProvided,
        QuestionAskerInterface $plaintextAsker,
        $plaintextValue
    ) {
        $this->algorithmId = $algorithmId;
        $this->key = $key;
        $this->keyProvided = (bool) $keyProvided;
        $this->plaintextQuestionAsker = $plaintextAsker;
        $this->plaintextValue = $plaintextValue;
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

    /**
     * Getter: plaintextQuestionAsker.
     *
     * @return QuestionAskerInterface
     */
    public function getPlaintextQuestionAsker()
    {
        return $this->plaintextQuestionAsker;
    }

    /**
     * Getter: plaintextValue.
     *
     * @return string
     */
    public function getPlaintextValue()
    {
        return $this->plaintextValue;
    }
}
