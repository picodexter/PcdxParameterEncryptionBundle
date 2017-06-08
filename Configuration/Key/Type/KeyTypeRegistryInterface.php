<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration\Key\Type;

/**
 * KeyTypeRegistryInterface.
 */
interface KeyTypeRegistryInterface
{
    /**
     * Getter: keyTypes.
     *
     * @return KeyTypeInterface[]
     */
    public function getKeyTypes();

    /**
     * Setter: keyTypes.
     *
     * @param KeyTypeInterface[] $keyTypes
     */
    public function setKeyTypes($keyTypes);

    /**
     * Add key type.
     *
     * @param KeyTypeInterface $keyType
     */
    public function add(KeyTypeInterface $keyType);

    /**
     * Get key type (if it exists).
     *
     * @param string $name
     *
     * @return KeyTypeInterface|null
     */
    public function get($name);

    /**
     * Check if key type with the name has been registered.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name);
}
