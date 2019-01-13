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

namespace Picodexter\ParameterEncryptionBundle\Encryption\Key;

use Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException;

/**
 * KeyNotEmptyValidator.
 */
class KeyNotEmptyValidator implements KeyNotEmptyValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function assertKeyNotEmpty($key)
    {
        if (empty($key)) {
            throw new EmptyKeyException();
        }
    }
}
