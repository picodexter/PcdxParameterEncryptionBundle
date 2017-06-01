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

use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\SplitValueBag;

class SplitValueBagTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetEncryptedValueSuccess()
    {
        $preparedValue = 'c';

        $bag = new SplitValueBag('a', 'b');

        $encryptedValue = $bag->getEncryptedValue();

        $this->assertNotSame($preparedValue, $encryptedValue);

        $bag->setEncryptedValue($preparedValue);

        $encryptedValue = $bag->getEncryptedValue();

        $this->assertSame($preparedValue, $encryptedValue);
    }

    public function testGetSetInitializationVectorSuccess()
    {
        $preparedValue = 'c';

        $bag = new SplitValueBag('a', 'b');

        $initializationVector = $bag->getInitializationVector();

        $this->assertNotSame($preparedValue, $initializationVector);

        $bag->setInitializationVector($preparedValue);

        $initializationVector = $bag->getInitializationVector();

        $this->assertSame($preparedValue, $initializationVector);
    }
}
