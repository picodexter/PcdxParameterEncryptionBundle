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
 * ValueSplitter.
 */
class ValueSplitter implements ValueSplitterInterface
{
    /**
     * @inheritDoc
     */
    public function split($mergedValue, $ivLength)
    {
        $mergedValue = (string) $mergedValue;
        $ivLength = (int) $ivLength;

        $this->assertValidInitializationVectorLength($ivLength);
        $this->assertValidMergedValueLength($mergedValue, $ivLength);

        $initializationVector = substr($mergedValue, 0, $ivLength);
        $encryptedValue = substr($mergedValue, $ivLength);

        return new SplitValueBag($encryptedValue, $initializationVector);
    }

    /**
     * Assert that initialization vector length is valid.
     *
     * @param int $ivLength
     *
     * @throws InvalidInitializationVectorLengthException
     */
    private function assertValidInitializationVectorLength($ivLength)
    {
        if ($ivLength < 1) {
            throw new InvalidInitializationVectorLengthException();
        }
    }

    /**
     * Assert that merged value length is valid.
     *
     * @param string $mergedValue
     * @param int    $ivLength
     *
     * @throws MergedValueTooShortException
     */
    private function assertValidMergedValueLength($mergedValue, $ivLength)
    {
        if (\strlen($mergedValue) <= $ivLength) {
            throw new MergedValueTooShortException();
        }
    }
}
