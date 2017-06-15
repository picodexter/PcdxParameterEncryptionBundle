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
     * @var string|null
     */
    private $finalKey;

    /**
     * @var string|null
     */
    private $finalKeyEncoded;

    /**
     * @var string|null
     */
    private $originalKey;

    /**
     * Getter: finalKey.
     *
     * @return string|null
     */
    public function getFinalKey()
    {
        return $this->finalKey;
    }

    /**
     * Setter: finalKey.
     *
     * @param string|null $finalKey
     */
    public function setFinalKey($finalKey)
    {
        $this->finalKey = (null === $finalKey ? null : (string) $finalKey);
    }

    /**
     * Getter: finalKeyEncoded.
     *
     * @return string|null
     */
    public function getFinalKeyEncoded()
    {
        return $this->finalKeyEncoded;
    }

    /**
     * Setter: finalKeyEncoded.
     *
     * @param string|null $finalKeyEncoded
     */
    public function setFinalKeyEncoded($finalKeyEncoded)
    {
        $this->finalKeyEncoded = (null === $finalKeyEncoded ? null : (string) $finalKeyEncoded);
    }

    /**
     * Getter: originalKey.
     *
     * @return string|null
     */
    public function getOriginalKey()
    {
        return $this->originalKey;
    }

    /**
     * Setter: originalKey.
     *
     * @param string|null $originalKey
     */
    public function setOriginalKey($originalKey)
    {
        $this->originalKey = (null === $originalKey ? null : (string) $originalKey);
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
