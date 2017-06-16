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
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationFactory;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfigurationFactoryInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

class AlgorithmConfigurationFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlgorithmConfigurationFactory
     */
    private $factory;

    /**
     * @var KeyConfigurationFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $keyConfigFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->keyConfigFactory = $this->createKeyConfigurationFactoryInterfaceMock();

        $this->factory = new AlgorithmConfigurationFactory($this->keyConfigFactory);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->factory = null;
        $this->keyConfigFactory = null;
    }

    /**
     * @param array $algorithmConfig
     *
     * @dataProvider provideInvalidConfigData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmConfigurationException
     */
    public function testCreateAlgorithmConfigurationExceptionInvalidConfig(array $algorithmConfig)
    {
        $decrypter = $this->createDecrypterInterfaceMock();
        $encrypter = $this->createEncrypterInterfaceMock();
        $replacementPattern = $this->createReplacementPatternInterfaceMock();

        $this->factory->createAlgorithmConfiguration($algorithmConfig, $decrypter, $encrypter, $replacementPattern);
    }

    /**
     * Data provider.
     */
    public function provideInvalidConfigData()
    {
        $validConfig = $this->getValidConfig();

        $data = [];

        $dataSet = $validConfig;
        unset($dataSet['id']);
        $data['missing id'] = [$dataSet];

        $dataSet = $validConfig;
        unset($dataSet['decryption']);
        $data['missing decryption'] = [$dataSet];

        $dataSet = $validConfig;
        $dataSet['decryption'] = 'not an array';
        $data['not an array - decryption'] = [$dataSet];

        $dataSet = $validConfig;
        unset($dataSet['decryption']['key']);
        $data['missing decryption.key'] = [$dataSet];

        $dataSet = $validConfig;
        unset($dataSet['decryption']['service']);
        $data['missing decryption.service'] = [$dataSet];

        $dataSet = $validConfig;
        unset($dataSet['encryption']);
        $data['missing encryption'] = [$dataSet];

        $dataSet = $validConfig;
        $dataSet['encryption'] = 'not an array';
        $data['not an array - encryption'] = [$dataSet];

        $dataSet = $validConfig;
        unset($dataSet['encryption']['key']);
        $data['missing encryption.key'] = [$dataSet];

        $dataSet = $validConfig;
        unset($dataSet['encryption']['service']);
        $data['missing encryption.service'] = [$dataSet];

        return $data;
    }

    public function testCreateAlgorithmConfigurationSuccess()
    {
        $algorithmConfig = $this->getValidConfig();
        $decrypter = $this->createDecrypterInterfaceMock();
        $decrypterKeyConfig = $this->createKeyConfigurationMock();
        $encrypter = $this->createEncrypterInterfaceMock();
        $encrypterKeyConfig = $this->createKeyConfigurationMock();
        $replacementPattern = $this->createReplacementPatternInterfaceMock();

        $this->keyConfigFactory->expects($this->exactly(2))
            ->method('createKeyConfiguration')
            ->withConsecutive(
                $this->identicalTo($algorithmConfig['decryption']),
                $this->identicalTo($algorithmConfig['encryption'])
            )
            ->will($this->onConsecutiveCalls(
                $this->returnValue($decrypterKeyConfig),
                $this->returnValue($encrypterKeyConfig)
            ));

        $generatedConfig = $this->factory
            ->createAlgorithmConfiguration($algorithmConfig, $decrypter, $encrypter, $replacementPattern);

        $this->assertInstanceOf(AlgorithmConfiguration::class, $generatedConfig);
        $this->assertSame($algorithmConfig['id'], $generatedConfig->getId());
        $this->assertSame($decrypter, $generatedConfig->getDecrypter());
        $this->assertSame($algorithmConfig['decryption']['service'], $generatedConfig->getDecrypterServiceName());
        $this->assertSame($decrypterKeyConfig, $generatedConfig->getDecryptionKeyConfig());
        $this->assertSame($encrypter, $generatedConfig->getEncrypter());
        $this->assertSame($algorithmConfig['encryption']['service'], $generatedConfig->getEncrypterServiceName());
        $this->assertSame($encrypterKeyConfig, $generatedConfig->getEncryptionKeyConfig());
        $this->assertSame($replacementPattern, $generatedConfig->getReplacementPattern());
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
     * Create mock for KeyConfigurationFactoryInterface.
     *
     * @return KeyConfigurationFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyConfigurationFactoryInterfaceMock()
    {
        return $this->getMockBuilder(KeyConfigurationFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for KeyConfiguration.
     *
     * @return KeyConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyConfigurationMock()
    {
        return $this->getMockBuilder(KeyConfiguration::class)->getMock();
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

    /**
     * Get a sample valid configuration.
     *
     * @return array
     */
    private function getValidConfig()
    {
        return [
            'id' => 'algo_id',
            'decryption' => [
                'key' => [],
                'service' => 'decryption_service',
            ],
            'encryption' => [
                'key' => [],
                'service' => 'encryption_service',
            ],
        ];
    }
}