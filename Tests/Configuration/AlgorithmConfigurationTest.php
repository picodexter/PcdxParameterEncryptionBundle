<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Configuration;

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

class AlgorithmConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $id
     *
     * @dataProvider provideInvalidIdData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmIdException
     */
    public function testConstructorExceptionInvalidId($id)
    {
        $this->createAlgorithmConfigurationWithId($id);
    }

    /**
     * Data provider.
     */
    public function provideInvalidIdData()
    {
        return [
            'invalid - contains space' => [
                'some id',
            ],
            'invalid - contains dash' => [
                'some-id',
            ],
            'invalid - ' => [
                '',
            ],
        ];
    }

    /**
     * @param string $id
     * @param string $expectedId
     *
     * @dataProvider provideValidIdData
     */
    public function testConstructorSuccess($id, $expectedId)
    {
        $algorithm = $this->createAlgorithmConfigurationWithId($id);

        $this->assertSame($expectedId, $algorithm->getId());
    }

    /**
     * Data provider.
     */
    public function provideValidIdData()
    {
        return [
            'valid - lowercase letters' => [
                'abc',
                'abc',
            ],
            'valid - uppercase letters' => [
                'ABC',
                'abc',
            ],
            'valid - numbers' => [
                '123',
                '123',
            ],
            'valid - underscore' => [
                '_',
                '_',
            ],
            'valid - period' => [
                '.',
                '.',
            ],
            'valid - mixed' => [
                'abc_ABC.123',
                'abc_abc.123',
            ],
        ];
    }

    /**
     * @param string $id
     *
     * @dataProvider provideInvalidIdData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmIdException
     */
    public function testSetIdExceptionInvalidId($id)
    {
        $algorithm = $this->createAlgorithmConfigurationWithId('placeholder');

        $algorithm->setId($id);
    }

    /**
     * @param string $id
     * @param string $expectedId
     *
     * @dataProvider provideValidIdData
     */
    public function testSetIdSuccess($id, $expectedId)
    {
        $algorithm = $this->createAlgorithmConfigurationWithId('placeholder');

        $algorithm->setId($id);

        $this->assertSame($expectedId, $algorithm->getId());
    }

    public function testGetSetDecrypterSuccess()
    {
        $preparedDecrypter = $this->createDecrypterInterfaceMock();

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $decrypter = $algorithm->getDecrypter();

        $this->assertNotSame($preparedDecrypter, $decrypter);

        $algorithm->setDecrypter($preparedDecrypter);

        $decrypter = $algorithm->getDecrypter();

        $this->assertSame($preparedDecrypter, $decrypter);
    }

    public function testGetSetDecrypterServiceNameSuccess()
    {
        $preparedServiceName = 'service_name';

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $serviceName = $algorithm->getDecrypterServiceName();

        $this->assertNotSame($preparedServiceName, $serviceName);

        $algorithm->setDecrypterServiceName($preparedServiceName);

        $serviceName = $algorithm->getDecrypterServiceName();

        $this->assertSame($preparedServiceName, $serviceName);
    }

    public function testGetSetDecryptionKeySuccess()
    {
        $preparedKey = 'secret_foo123';

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $key = $algorithm->getDecryptionKey();

        $this->assertNotSame($preparedKey, $key);

        $algorithm->setDecryptionKey($preparedKey);

        $key = $algorithm->getDecryptionKey();

        $this->assertSame($preparedKey, $key);
    }

    public function testGetSetEncrypterSuccess()
    {
        $preparedEncrypter = $this->createEncrypterInterfaceMock();

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $encrypter = $algorithm->getEncrypter();

        $this->assertNotSame($preparedEncrypter, $encrypter);

        $algorithm->setEncrypter($preparedEncrypter);

        $encrypter = $algorithm->getEncrypter();

        $this->assertSame($preparedEncrypter, $encrypter);
    }

    public function testGetSetEncrypterServiceNameSuccess()
    {
        $preparedServiceName = 'service_name';

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $serviceName = $algorithm->getEncrypterServiceName();

        $this->assertNotSame($preparedServiceName, $serviceName);

        $algorithm->setEncrypterServiceName($preparedServiceName);

        $serviceName = $algorithm->getEncrypterServiceName();

        $this->assertSame($preparedServiceName, $serviceName);
    }

    public function testGetSetEncryptionKeySuccess()
    {
        $preparedKey = 'secret_foo123';

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $key = $algorithm->getEncryptionKey();

        $this->assertNotSame($preparedKey, $key);

        $algorithm->setEncryptionKey($preparedKey);

        $key = $algorithm->getEncryptionKey();

        $this->assertSame($preparedKey, $key);
    }

    public function testGetSetReplacementPatternSuccess()
    {
        $preparedPattern = $this->createReplacementPatternInterfaceMock();

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $pattern = $algorithm->getReplacementPattern();

        $this->assertNotSame($preparedPattern, $pattern);

        $algorithm->setReplacementPattern($preparedPattern);

        $pattern = $algorithm->getReplacementPattern();

        $this->assertSame($preparedPattern, $pattern);
    }

    /**
     * Create AlgorithmConfiguration with ID.
     *
     * @param string $id
     * @return AlgorithmConfiguration
     */
    private function createAlgorithmConfigurationWithId($id)
    {
        $decrypter = $this->createDecrypterInterfaceMock();
        $encrypter = $this->createEncrypterInterfaceMock();
        $replacementPattern = $this->createReplacementPatternInterfaceMock();

        return new AlgorithmConfiguration(
            $id,
            $decrypter,
            'decrypter_service',
            'key_decryption',
            $encrypter,
            'encrypter_service',
            'key_encryption',
            $replacementPattern
        );
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
     * Create mock for EncrypterInterface.
     *
     * @return EncrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createEncrypterInterfaceMock()
    {
        return $this->getMockBuilder(EncrypterInterface::class)->getMock();
    }

    /**
     * Create mock for ReplacementPatternInterface.
     *
     * @return ReplacementPatternInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReplacementPatternInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInterface::class)->getMock();
    }
}
