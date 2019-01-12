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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmIdException;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

class AlgorithmConfigurationTest extends TestCase
{
    /**
     * @param string $id
     *
     * @dataProvider provideInvalidIdData
     */
    public function testConstructorExceptionInvalidId($id)
    {
        $this->expectException(InvalidAlgorithmIdException::class);

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
     */
    public function testSetIdExceptionInvalidId($id)
    {
        $this->expectException(InvalidAlgorithmIdException::class);

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
        $preparedKeyConfig = $this->createKeyConfigurationMock();

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $key = $algorithm->getDecryptionKeyConfig();

        $this->assertNotSame($preparedKeyConfig, $key);

        $algorithm->setDecryptionKeyConfig($preparedKeyConfig);

        $key = $algorithm->getDecryptionKeyConfig();

        $this->assertSame($preparedKeyConfig, $key);
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
        $preparedKeyConfig = $this->createKeyConfigurationMock();

        $algorithm = $this->createAlgorithmConfigurationWithId('algo_01');

        $key = $algorithm->getEncryptionKeyConfig();

        $this->assertNotSame($preparedKeyConfig, $key);

        $algorithm->setEncryptionKeyConfig($preparedKeyConfig);

        $key = $algorithm->getEncryptionKeyConfig();

        $this->assertSame($preparedKeyConfig, $key);
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
     *
     * @return AlgorithmConfiguration
     */
    private function createAlgorithmConfigurationWithId($id)
    {
        $decrypter = $this->createDecrypterInterfaceMock();
        $decryptionKeyConfig = $this->createKeyConfigurationMock();
        $encrypter = $this->createEncrypterInterfaceMock();
        $encryptionKeyConfig = $this->createKeyConfigurationMock();
        $replacementPattern = $this->createReplacementPatternInterfaceMock();

        return new AlgorithmConfiguration(
            $id,
            $decrypter,
            'decrypter_service',
            $decryptionKeyConfig,
            $encrypter,
            'encrypter_service',
            $encryptionKeyConfig,
            $replacementPattern
        );
    }

    /**
     * Create mock for DecrypterInterface.
     *
     * @return DecrypterInterface|MockObject
     */
    private function createDecrypterInterfaceMock()
    {
        return $this->getMockBuilder(DecrypterInterface::class)->getMock();
    }

    /**
     * Create mock for EncrypterInterface.
     *
     * @return EncrypterInterface|MockObject
     */
    private function createEncrypterInterfaceMock()
    {
        return $this->getMockBuilder(EncrypterInterface::class)->getMock();
    }

    /**
     * Create mock for KeyConfiguration.
     *
     * @return \Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration|MockObject
     */
    private function createKeyConfigurationMock()
    {
        return $this->getMockBuilder(\Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration::class)->getMock();
    }

    /**
     * Create mock for ReplacementPatternInterface.
     *
     * @return ReplacementPatternInterface|MockObject
     */
    private function createReplacementPatternInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInterface::class)->getMock();
    }
}
