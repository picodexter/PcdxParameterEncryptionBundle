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
     * @param array $algorithmConfig
     *
     * @dataProvider provideInvalidConfigData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\InvalidAlgorithmConfigurationException
     */
    public function testGetReplacementPatternServiceNameForAlgorithmExceptionInvalidConfig(
        array $algorithmConfig
    ) {
        $initializer = new AbstractInitializerDummy();

        $initializer->getReplacementPatternServiceNameForAlgorithm($algorithmConfig);
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
        $initializer = new AbstractInitializerDummy();

        $serviceName = $initializer->getReplacementPatternServiceNameForAlgorithm([
            'id' => 'foo',
        ]);

        $this->assertSame(ServiceNames::REPLACEMENT_PATTERN_ALGORITHM_PREFIX . 'foo', $serviceName);
    }
}
