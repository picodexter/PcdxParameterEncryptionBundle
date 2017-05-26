<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Processor
     */
    private $configProcessor;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->configuration = new Configuration();
        $this->configProcessor = new Processor();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->configuration = null;
    }

    /**
     * @param array $config
     *
     * @dataProvider provideConfigurationSuccessData
     */
    public function testConfigurationSuccess(array $config)
    {
        $processedConfig = $this->configProcessor->processConfiguration($this->configuration, $config);

        $this->assertNotEmpty($processedConfig);
    }

    /**
     * Data provider.
     */
    public function provideConfigurationSuccessData()
    {
        return [
            'minimal' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => 'algo_01',
                                'pattern' => [
                                    'type' => 'value_prefix',
                                ],
                                'encryption' => [
                                    'service' => 'algo_01_encrypter',
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'complete' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => 'algo_01',
                                'pattern' => [
                                    'type' => 'value_prefix',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                                'encryption' => [
                                    'service' => 'algo_01_encrypter',
                                    'key' => 'algo_01_encryption_key',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                    'key' => 'algo_01_decryption_key',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                            ],
                            [
                                'id' => 'algo_02',
                                'pattern' => [
                                    'type' => 'value_prefix',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                                'encryption' => [
                                    'service' => 'algo_02_encrypter',
                                    'key' => 'algo_02_encryption_key',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_02_decrypter',
                                    'key' => 'algo_02_decryption_key',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                            ],
                            [
                                'id' => 'algo_03',
                                'pattern' => [
                                    'type' => 'value_prefix',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                                'encryption' => [
                                    'service' => 'algo_03_encrypter',
                                    'key' => 'algo_03_encryption_key',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_03_decrypter',
                                    'key' => 'algo_03_decryption_key',
                                    'arguments' => [
                                        'argument1',
                                        'argument2',
                                        'argument3',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param array $config
     *
     * @dataProvider provideConfigurationFailureData
     * @expectedException \Symfony\Component\Config\Definition\Exception\Exception
     */
    public function testConfigurationFailure(array $config)
    {
        $this->configProcessor->processConfiguration($this->configuration, $config);
    }

    /**
     * Data provider.
     */
    public function provideConfigurationFailureData()
    {
        return [
            'completely empty' => [
                [],
            ],
            'extension config is empty' => [
                [
                    'pcdx_parameter_encryption' => [],
                ],
            ],
            'no algorithms' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [],
                    ],
                ],
            ],
            'algorithm.id is empty' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => null,
                                'pattern' => [
                                    'type' => 'value_prefix',
                                ],
                                'encryption' => [
                                    'service' => 'algo_01_encrypter',
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithm.pattern is empty' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => null,
                                'pattern' => [],
                                'encryption' => [
                                    'service' => 'algo_01_encrypter',
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithm.pattern.type is empty' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => null,
                                'pattern' => [
                                    'type' => null,
                                ],
                                'encryption' => [
                                    'service' => 'algo_01_encrypter',
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithm.encryption is empty' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => 'algo_01',
                                'pattern' => [
                                    'type' => 'value_prefix',
                                ],
                                'encryption' => [],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithm.encryption.service is empty' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => 'algo_01',
                                'pattern' => [
                                    'type' => 'value_prefix',
                                ],
                                'encryption' => [
                                    'service' => null,
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithm.decryption is empty' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => 'algo_01',
                                'pattern' => [
                                    'type' => 'value_prefix',
                                ],
                                'encryption' => [
                                    'service' => 'algo_01_encrypter',
                                ],
                                'decryption' => [],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithm.decryption.service is empty' => [
                [
                    'pcdx_parameter_encryption' => [
                        'algorithms' => [
                            [
                                'id' => 'algo_01',
                                'pattern' => [
                                    'type' => 'value_prefix',
                                ],
                                'encryption' => [
                                    'service' => 'algo_01_encrypter',
                                ],
                                'decryption' => [
                                    'service' => null,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
