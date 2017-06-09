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
 * KeyTypeRegistry.
 */
class KeyTypeRegistry implements KeyTypeRegistryInterface
{
    /**
     * @var KeyTypeInterface[]
     */
    private $keyTypes = [];

    /**
     * Constructor.
     *
     * @param KeyTypeInterface[] $keyTypes
     */
    public function __construct(array $keyTypes)
    {
        $this->setKeyTypes($keyTypes);
    }

    /**
     * @inheritDoc
     */
    public function getKeyTypes()
    {
        return $this->keyTypes;
    }

    /**
     * @inheritDoc
     */
    public function setKeyTypes($keyTypes)
    {
        foreach ($keyTypes as $keyType) {
            if ($keyType instanceof KeyTypeInterface) {
                $this->add($keyType);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function add(KeyTypeInterface $keyType)
    {
        if (!$this->has($keyType->getName())) {
            $this->keyTypes[$keyType->getName()] = $keyType;
        }
    }

    /**
     * @inheritDoc
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return $this->keyTypes[$name];
        } else {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function has($name)
    {
        return array_key_exists($name, $this->keyTypes);
    }
}
