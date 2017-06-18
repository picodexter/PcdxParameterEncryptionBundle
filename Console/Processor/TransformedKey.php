<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Processor;

/**
 * TransformedKey.
 */
class TransformedKey
{
    /**
     * @var string
     */
    private $finalKey = '';

    /**
     * @var string
     */
    private $finalKeyEncoded = '';

    /**
     * @var string
     */
    private $originalKey = '';

    /**
     * Getter: finalKey.
     *
     * @return string
     */
    public function getFinalKey()
    {
        return $this->finalKey;
    }

    /**
     * Setter: finalKey.
     *
     * @param string $finalKey
     */
    public function setFinalKey($finalKey)
    {
        $this->finalKey = (string) $finalKey;
    }

    /**
     * Getter: finalKeyEncoded.
     *
     * @return string
     */
    public function getFinalKeyEncoded()
    {
        return $this->finalKeyEncoded;
    }

    /**
     * Setter: finalKeyEncoded.
     *
     * @param string $finalKeyEncoded
     */
    public function setFinalKeyEncoded($finalKeyEncoded)
    {
        $this->finalKeyEncoded = (string) $finalKeyEncoded;
    }

    /**
     * Getter: originalKey.
     *
     * @return string
     */
    public function getOriginalKey()
    {
        return $this->originalKey;
    }

    /**
     * Setter: originalKey.
     *
     * @param string $originalKey
     */
    public function setOriginalKey($originalKey)
    {
        $this->originalKey = (string) $originalKey;
    }

    /**
     * Check if key has changed.
     *
     * @return bool
     */
    public function hasChanged()
    {
        return ($this->originalKey !== $this->finalKey);
    }
}
