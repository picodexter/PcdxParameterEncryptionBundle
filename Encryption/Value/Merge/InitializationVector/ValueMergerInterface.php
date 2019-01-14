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
 * ValueMergerInterface.
 */
interface ValueMergerInterface
{
    /**
     * Merge encrypted value and initialization vector.
     *
     * @param string $encryptedValue
     * @param string $initializationVector
     *
     * @return string
     */
    public function merge($encryptedValue, $initializationVector);
}
