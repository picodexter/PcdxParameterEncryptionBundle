<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Decrypter;

use Picodexter\ParameterEncryptionBundle\Encryption\CaesarCipherInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\CaesarDecrypter;

class CaesarDecrypterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CaesarCipherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $cipher;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->cipher = $this->createCaesarCipherInterfaceMock();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->cipher = null;
    }

    public function testDecryptValueSuccessNoRotationAmount()
    {
        $decrypter = new CaesarDecrypter($this->cipher);

        $this->cipher->expects($this->once())
            ->method('apply')
            ->with(
                $this->identicalTo('foo'),
                $this->identicalTo(-13)
            )
            ->will($this->returnValue('foo'));

        $decryptedValue = $decrypter->decryptValue('foo');

        $this->assertSame('foo', $decryptedValue);
    }

    public function testDecryptValueSuccessWithRotationAmount()
    {
        $decrypter = new CaesarDecrypter($this->cipher, 7);

        $this->cipher->expects($this->once())
            ->method('apply')
            ->with(
                $this->identicalTo('foo'),
                $this->identicalTo(-7)
            )
            ->will($this->returnValue('foo'));

        $decryptedValue = $decrypter->decryptValue('foo');

        $this->assertSame('foo', $decryptedValue);
    }

    /**
     * Create mock for CaesarCipherInterface.
     */
    private function createCaesarCipherInterfaceMock()
    {
        return $this->getMockBuilder(CaesarCipherInterface::class)->getMock();
    }
}
