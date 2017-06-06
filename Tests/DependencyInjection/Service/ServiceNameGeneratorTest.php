<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGenerator;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;

class ServiceNameGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceNameGenerator
     */
    private $generator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->generator = new ServiceNameGenerator();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->generator = null;
    }

    /**
     * @param array $algorithmConfig
     *
     * @dataProvider provideInvalidAlgorithmConfigData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmConfigurationException
     */
    public function testGetAlgorithmConfigurationServiceNameForAlgorithmExceptionInvalidConfig(array $algorithmConfig)
    {
        $this->generator->getAlgorithmConfigurationServiceNameForAlgorithm($algorithmConfig);
    }

    /**
     * Data provider.
     */
    public function provideInvalidAlgorithmConfigData()
    {
        return [
            'empty' => [
                [],
            ],
            'no key "id"' => [
                [
                    'foo' => 'bar',
                ],
            ],
            '"id" value is not a string' => [
                [
                    'foo' => 1.234,
                ],
            ],
        ];
    }

    public function testGetAlgorithmConfigurationServiceNameForAlgorithmSuccess()
    {
        $preparedAlgorithmId = 'foo';

        $serviceName = $this->generator->getAlgorithmConfigurationServiceNameForAlgorithm([
            'id' => $preparedAlgorithmId,
        ]);

        $this->assertSame(ServiceNames::ALGORITHM_CONFIGURATION_PREFIX.$preparedAlgorithmId, $serviceName);
    }

    /**
     * @param array $algorithmConfig
     *
     * @dataProvider provideInvalidAlgorithmConfigData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmConfigurationException
     */
    public function testGetReplacementPatternServiceNameForAlgorithmExceptionInvalidConfig(
        array $algorithmConfig
    ) {
        $this->generator->getReplacementPatternServiceNameForAlgorithm($algorithmConfig);
    }

    public function testGetReplacementPatternServiceNameForAlgorithmSuccess()
    {
        $preparedAlgorithmId = 'foo';

        $serviceName = $this->generator->getReplacementPatternServiceNameForAlgorithm([
            'id' => $preparedAlgorithmId,
        ]);

        $this->assertSame(ServiceNames::REPLACEMENT_PATTERN_ALGORITHM_PREFIX.$preparedAlgorithmId, $serviceName);
    }

    /**
     * @param array $algorithmConfig
     *
     * @dataProvider provideInvalidAlgorithmConfigData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmConfigurationException
     */
    public function testGetReplacementSourceDecrypterServiceNameForAlgorithmExceptionInvalidConfig(
        array $algorithmConfig
    ) {
        $this->generator->getReplacementSourceDecrypterServiceNameForAlgorithm($algorithmConfig);
    }

    public function testGetReplacementSourceDecrypterServiceNameForAlgorithmSuccess()
    {
        $preparedAlgorithmId = 'foo';

        $serviceName = $this->generator->getReplacementSourceDecrypterServiceNameForAlgorithm([
            'id' => $preparedAlgorithmId,
        ]);

        $this->assertSame(
            ServiceNames::REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX.$preparedAlgorithmId,
            $serviceName
        );
    }
}
