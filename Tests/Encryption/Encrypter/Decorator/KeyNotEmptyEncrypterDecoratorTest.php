<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Encrypter\Decorator;

use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\Decorator\KeyNotEmptyEncrypterDecorator;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyNotEmptyValidatorInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException;

class KeyNotEmptyEncrypterDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyNotEmptyEncrypterDecorator
     */
    private $decorator;

    /**
     * @var EncrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $encrypter;

    /**
     * @var KeyNotEmptyValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $keyNotEmptyValidator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->encrypter = $this->createEncrypterInterfaceMock();
        $this->keyNotEmptyValidator = $this->createKeyNotEmptyValidatorInterfaceMock();

        $this->decorator = new KeyNotEmptyEncrypterDecorator($this->encrypter, $this->keyNotEmptyValidator);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->decorator = null;
        $this->keyNotEmptyValidator = null;
        $this->encrypter = null;
    }

    /**
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException
     */
    public function testEncryptValueExceptionEmptyKey()
    {
        $plainValue = 'some plain value';
        $encryptionKey = '';

        $this->keyNotEmptyValidator->expects($this->once())
            ->method('assertKeyNotEmpty')
            ->with($this->identicalTo($encryptionKey))
            ->will($this->throwException(new EmptyKeyException()));

        $this->decorator->encryptValue($plainValue, $encryptionKey);
    }

    public function testEncryptValueSuccess()
    {
        $plainValue = 'some plain value';
        $encryptionKey = 'some key';
        $prepDecryptedValue = 'decrypted value';

        $this->encrypter->expects($this->once())
            ->method('encryptValue')
            ->with(
                $this->identicalTo($plainValue),
                $this->identicalTo($encryptionKey)
            )
            ->will($this->returnValue($prepDecryptedValue));

        $decryptedValue = $this->decorator->encryptValue($plainValue, $encryptionKey);

        $this->assertSame($prepDecryptedValue, $decryptedValue);
    }

    /**
     * Create mock for EncrypterInterface.
     *
     * @return EncrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createEncrypterInterfaceMock()
    {
        return $this->getMockBuilder(EncrypterInterface::class)->getMock();
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
