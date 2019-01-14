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

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Encrypter;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Encryption\Algorithm\CaesarCipher\CaesarCipherInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\CaesarEncrypter;

class CaesarEncrypterTest extends TestCase
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

    public function testEncryptValueSuccessNoRotationAmount()
    {
        $plainValue = 'foo';
        $preparedValue = 'encrypted foo';

        $encrypter = new CaesarEncrypter($this->cipher);

        $this->cipher->expects($this->once())
            ->method('apply')
            ->with(
                $this->identicalTo($plainValue),
                $this->identicalTo(13)
            )
            ->will($this->returnValue($preparedValue));

        $encryptedValue = $encrypter->encryptValue($plainValue, '');

        $this->assertSame($preparedValue, $encryptedValue);
    }

    public function testEncryptValueSuccessWithRotationAmount()
    {
        $plainValue = 'foo';
        $preparedValue = 'encrypted foo';
        $rotationAmount = 7;

        $encrypter = new CaesarEncrypter($this->cipher, $rotationAmount);

        $this->cipher->expects($this->once())
            ->method('apply')
            ->with(
                $this->identicalTo($plainValue),
                $this->identicalTo($rotationAmount)
            )
            ->will($this->returnValue($preparedValue));

        $encryptedValue = $encrypter->encryptValue($plainValue, '');

        $this->assertSame($preparedValue, $encryptedValue);
    }

    /**
     * Create mock for CaesarCipherInterface.
     */
    private function createCaesarCipherInterfaceMock()
    {
        return $this->getMockBuilder(CaesarCipherInterface::class)->getMock();
    }
}
