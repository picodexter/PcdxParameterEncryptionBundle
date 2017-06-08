<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration\Key;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\StaticKeyType;

/**
 * KeyConfiguration.
 */
class KeyConfiguration
{
    /**
     * @var int|null
     */
    private $cost = null;

    /**
     * @var string|null
     */
    private $hashAlgorithm = null;

    /**
     * @var string|null
     */
    private $method = null;

    /**
     * @var string|null
     */
    private $salt = null;

    /**
     * @var string
     */
    private $type = StaticKeyType::TYPE_NAME;

    /**
     * @var string|null
     */
    private $value = null;

    /**
     * Getter: cost.
     *
     * @return int|null
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Setter: cost.
     *
     * @param int|null $cost
     */
    public function setCost($cost)
    {
        $this->cost = (null === $cost ? null : (int) $cost);
    }

    /**
     * Getter: hashAlgorithm.
     *
     * @return string|null
     */
    public function getHashAlgorithm()
    {
        return $this->hashAlgorithm;
    }

    /**
     * Setter: hashAlgorithm.
     *
     * @param string|null $hashAlgorithm
     */
    public function setHashAlgorithm($hashAlgorithm)
    {
        $this->hashAlgorithm = $hashAlgorithm;
    }

    /**
     * Getter: method.
     *
     * @return string|null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Setter: method.
     *
     * @param string|null $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Getter: salt.
     *
     * @return string|null
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Setter: salt.
     *
     * @param string|null $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Getter: type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setter: type.
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Getter: value.
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Setter: value.
     *
     * @param string|null $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
