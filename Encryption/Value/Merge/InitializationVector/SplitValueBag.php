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

namespace Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector;

/**
 * SplitValueBag.
 */
class SplitValueBag
{
    /**
     * @var string
     */
    private $encryptedValue;

    /**
     * @var string
     */
    private $initializationVector;

    /**
     * Constructor.
     *
     * @param string $encryptedValue
     * @param string $initializationVector
     */
    public function __construct($encryptedValue, $initializationVector)
    {
        $this->encryptedValue = $encryptedValue;
        $this->initializationVector = $initializationVector;
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
     * Setter: encryptedValue.
     *
     * @param string $encryptedValue
     */
    public function setEncryptedValue($encryptedValue)
    {
        $this->encryptedValue = $encryptedValue;
    }

    /**
     * Getter: initializationVector.
     *
     * @return string
     */
    public function getInitializationVector()
    {
        return $this->initializationVector;
    }

    /**
     * Setter: initializationVector.
     *
     * @param string $initializationVector
     */
    public function setInitializationVector($initializationVector)
    {
        $this->initializationVector = $initializationVector;
    }
}
