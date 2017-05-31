<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Value\Merge\InitializationVector;

use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\ValueMerger;

class ValueMergerTest extends \PHPUnit_Framework_TestCase
{
    public function testMergeSuccess()
    {
        $encryptedValue = 'encrypted value';
        $initializationVector = 'init vector';
        $expectedValue = 'init vectorencrypted value';

        $merger = new ValueMerger();

        $mergedValue = $merger->merge($encryptedValue, $initializationVector);

        $this->assertSame($expectedValue, $mergedValue);
    }
}
