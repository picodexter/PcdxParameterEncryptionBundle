<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Initializer;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;

class AbstractInitializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractInitializerDummy
     */
    private $initializer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->initializer = new AbstractInitializerDummy();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->initializer = null;
    }

    /**
     * @param array $algorithmConfig
     *
     * @dataProvider provideInvalidConfigData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\InvalidAlgorithmConfigurationException
     */
    public function testGetReplacementPatternServiceNameForAlgorithmExceptionInvalidConfig(
        array $algorithmConfig
    ) {
        $this->initializer->getReplacementPatternServiceNameForAlgorithm($algorithmConfig);
    }

    /**
     * Data provider.
     */
    public function provideInvalidConfigData()
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

    public function testGetReplacementPatternServiceNameForAlgorithmSuccessValidConfig()
    {
        $serviceName = $this->initializer->getReplacementPatternServiceNameForAlgorithm([
            'id' => 'foo',
        ]);

        $this->assertSame(ServiceNames::REPLACEMENT_PATTERN_ALGORITHM_PREFIX . 'foo', $serviceName);
    }
}
