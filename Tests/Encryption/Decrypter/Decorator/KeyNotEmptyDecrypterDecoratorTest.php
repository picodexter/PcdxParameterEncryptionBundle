<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Decrypter\Decorator;

use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\Decorator\KeyNotEmptyDecrypterDecorator;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyNotEmptyValidatorInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException;

class KeyNotEmptyDecrypterDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyNotEmptyDecrypterDecorator
     */
    private $decorator;

    /**
     * @var DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $decrypter;

    /**
     * @var KeyNotEmptyValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $keyNotEmptyValidator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->decrypter = $this->createDecrypterInterfaceMock();
        $this->keyNotEmptyValidator = $this->createKeyNotEmptyValidatorInterfaceMock();

        $this->decorator = new KeyNotEmptyDecrypterDecorator($this->decrypter, $this->keyNotEmptyValidator);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->decorator = null;
        $this->keyNotEmptyValidator = null;
        $this->decrypter = null;
    }

    /**
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException
     */
    public function testDecryptValueExceptionKeyEmpty()
    {
        $encryptedValue = 'some encrypted value';
        $decryptionKey = '';

        $this->keyNotEmptyValidator->expects($this->once())
            ->method('assertKeyNotEmpty')
            ->with($this->identicalTo($decryptionKey))
            ->will($this->throwException(new EmptyKeyException()));

        $this->decorator->decryptValue($encryptedValue, $decryptionKey);
    }

    public function testDecryptValueSuccess()
    {
        $encryptedValue = 'some encrypted value';
        $decryptionKey = 'some key';
        $prepDecryptedValue = 'decrypted value';

        $this->decrypter->expects($this->once())
            ->method('decryptValue')
            ->with(
                $this->identicalTo($encryptedValue),
                $this->identicalTo($decryptionKey)
            )
            ->will($this->returnValue($prepDecryptedValue));

        $decryptedValue = $this->decorator->decryptValue($encryptedValue, $decryptionKey);

        $this->assertSame($prepDecryptedValue, $decryptedValue);
    }

    /**
     * Create mock for DecrypterInterface.
     *
     * @return DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDecrypterInterfaceMock()
    {
        return $this->getMockBuilder(DecrypterInterface::class)->getMock();
    }

    /**
     * Create mock for KeyNotEmptyValidatorInterface.
     *
     * @return KeyNotEmptyValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyNotEmptyValidatorInterfaceMock()
    {
        return $this->getMockBuilder(KeyNotEmptyValidatorInterface::class)->getMock();
    }
}
