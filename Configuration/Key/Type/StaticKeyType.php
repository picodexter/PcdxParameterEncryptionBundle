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
 * StaticKeyType.
 */
class StaticKeyType implements KeyTypeInterface
{
    const TYPE_NAME = 'static';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::TYPE_NAME;
    }
}
