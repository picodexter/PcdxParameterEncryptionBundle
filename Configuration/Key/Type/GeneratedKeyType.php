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

namespace Picodexter\ParameterEncryptionBundle\Configuration\Key\Type;

/**
 * GeneratedKeyType.
 */
class GeneratedKeyType implements KeyTypeInterface
{
    const TYPE_NAME = 'generated';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::TYPE_NAME;
    }
}
