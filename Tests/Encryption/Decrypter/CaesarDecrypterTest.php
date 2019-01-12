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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Encryption\Algorithm\CaesarCipher\CaesarCipherInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\CaesarDecrypter;

class CaesarDecrypterTest extends TestCase
{
    /**
     * @var CaesarCipherInterface|MockObject
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
        $encryptedValue = 'foo';
        $preparedValue = 'decrypted foo';

        $decrypter = new CaesarDecrypter($this->cipher);

        $this->cipher->expects($this->once())
            ->method('apply')
            ->with(
                $this->identicalTo($encryptedValue),
                $this->identicalTo(-13)
            )
            ->will($this->returnValue($preparedValue));

        $decryptedValue = $decrypter->decryptValue($encryptedValue, '');

        $this->assertSame($preparedValue, $decryptedValue);
    }

    public function testDecryptValueSuccessWithRotationAmount()
    {
        $encryptedValue = 'foo';
        $preparedValue = 'decrypted foo';
        $encrRotationAmount = 7;

        $decrypter = new CaesarDecrypter($this->cipher, $encrRotationAmount);

        $this->cipher->expects($this->once())
            ->method('apply')
            ->with(
                $this->identicalTo($encryptedValue),
                $this->identicalTo(-1 * $encrRotationAmount)
            )
            ->will($this->returnValue($preparedValue));

        $decryptedValue = $decrypter->decryptValue($encryptedValue, '');

        $this->assertSame($preparedValue, $decryptedValue);
    }

    /**
     * Create mock for CaesarCipherInterface.
     */
    private function createCaesarCipherInterfaceMock()
    {
        return $this->getMockBuilder(CaesarCipherInterface::class)->getMock();
    }
}
