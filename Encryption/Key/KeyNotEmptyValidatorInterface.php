<?php

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
 * KeyNotEmptyValidatorInterface.
 */
interface KeyNotEmptyValidatorInterface
{
    /**
     * Assert that key is not empty.
     *
     * @param string $key
     *
     * @throws EmptyKeyException
     */
    public function assertKeyNotEmpty($key);
}
