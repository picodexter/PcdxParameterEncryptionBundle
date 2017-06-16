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

use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\KeyTypeInterface;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\StaticKeyType;

/**
 * KeyConfiguration.
 */
class KeyConfiguration
{
    /**
     * @var bool
     */
    private $base64Encoded = false;

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
     * @var KeyTypeInterface
     */
    private $type = null;

    /**
     * @var string|null
     */
    private $value = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->type = new StaticKeyType();
    }

    /**
     * Getter: base64Encoded.
     *
     * @return bool
     */
    public function isBase64Encoded()
    {
        return $this->base64Encoded;
    }

    /**
     * Setter: base64Encoded.
     *
     * @param bool $base64Encoded
     */
    public function setBase64Encoded($base64Encoded)
    {
        $this->base64Encoded = (bool) $base64Encoded;
    }

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
     * @return KeyTypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setter: type.
     *
     * @param KeyTypeInterface $type
     */
    public function setType(KeyTypeInterface $type)
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
