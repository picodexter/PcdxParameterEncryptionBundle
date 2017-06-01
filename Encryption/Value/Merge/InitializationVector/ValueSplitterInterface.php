<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector;

use Picodexter\ParameterEncryptionBundle\Exception\Encryption\InvalidInitializationVectorLengthException;
use Picodexter\ParameterEncryptionBundle\Exception\Encryption\MergedValueTooShortException;

/**
 * ValueSplitterInterface.
 */
interface ValueSplitterInterface
{
    /**
     * Split merged value into encrypted value and initialization vector.
     *
     * @param string $mergedValue
     * @param int    $ivLength
     *
     * @throws InvalidInitializationVectorLengthException
     * @throws MergedValueTooShortException
     *
     * @return SplitValueBag
     */
    public function split($mergedValue, $ivLength);
}
