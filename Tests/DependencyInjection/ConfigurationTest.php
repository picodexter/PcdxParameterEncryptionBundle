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
            'minimal with minimal static keys' => [
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
                                    'key' => 'algo_01_encryption_key',
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                    'key' => 'algo_01_decryption_key',
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
                                    'key' => [
                                        'value'          => 'algo_01_encryption_password',
                                        'base64_encoded' => true,
                                        'type'           => 'generated',
                                        'method'         => 'pbkdf2',
                                        'hash_algorithm' => 'sha512',
                                        'salt'           => 'algo_01_encryption_password_salt',
                                        'cost'           => 1000,
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                    'key' => [
                                        'value'          => 'algo_01_decryption_password',
                                        'base64_encoded' => true,
                                        'type'           => 'generated',
                                        'method'         => 'pbkdf2',
                                        'hash_algorithm' => 'sha512',
                                        'salt'           => 'algo_01_decryption_password_salt',
                                        'cost'           => 1000,
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
                                    'key' => [
                                        'value'          => 'algo_02_encryption_password',
                                        'base64_encoded' => true,
                                        'type'           => 'generated',
                                        'method'         => 'pbkdf2',
                                        'hash_algorithm' => 'sha512',
                                        'salt'           => 'algo_02_encryption_password_salt',
                                        'cost'           => 1000,
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_02_decrypter',
                                    'key' => [
                                        'value'          => 'algo_02_decryption_password',
                                        'base64_encoded' => true,
                                        'type'           => 'generated',
                                        'method'         => 'pbkdf2',
                                        'hash_algorithm' => 'sha512',
                                        'salt'           => 'algo_02_decryption_password_salt',
                                        'cost'           => 1000,
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
                                    'key' => [
                                        'value'          => 'algo_03_encryption_password',
                                        'base64_encoded' => true,
                                        'type'           => 'generated',
                                        'method'         => 'pbkdf2',
                                        'hash_algorithm' => 'sha512',
                                        'salt'           => 'algo_03_encryption_password_salt',
                                        'cost'           => 1000,
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_03_decrypter',
                                    'key' => [
                                        'value'          => 'algo_03_decryption_password',
                                        'base64_encoded' => true,
                                        'type'           => 'generated',
                                        'method'         => 'pbkdf2',
                                        'hash_algorithm' => 'sha512',
                                        'salt'           => 'algo_03_decryption_password_salt',
                                        'cost'           => 1000,
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
            'algorithms.#.id is empty' => [
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
            'algorithms.#.pattern is empty' => [
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
            'algorithms.#.pattern.type is empty' => [
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
            'algorithms.#.encryption is empty' => [
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
            'algorithms.#.encryption.service is empty' => [
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
            'algorithms.#.encryption.key.base64_encoded is set and not boolean' => [
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
                                    'key' => [
                                        'base64_encoded' => '1',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.encryption.key.type is set and empty' => [
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
                                    'key' => [
                                        'type' => '',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.encryption.key.method is set and empty' => [
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
                                    'key' => [
                                        'method' => '',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.encryption.key.hash_algorithm is set and empty' => [
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
                                    'key' => [
                                        'hash_algorithm' => '',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.encryption.key.salt is set and empty' => [
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
                                    'key' => [
                                        'salt' => '',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.encryption.key.cost is set and not an integer' => [
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
                                    'key' => [
                                        'cost' => 'not an integer',
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.encryption.key.cost is set and < 1' => [
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
                                    'key' => [
                                        'cost' => 0,
                                    ],
                                ],
                                'decryption' => [
                                    'service' => 'algo_01_decrypter',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.decryption is empty' => [
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
            'algorithms.#.decryption.service is empty' => [
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
            'algorithms.#.decryption.key.base64_encoded is set and not boolean' => [
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
                                    'key' => [
                                        'base64_encoded' => '1',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.decryption.key.type is set and empty' => [
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
                                    'key' => [
                                        'type' => '',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.decryption.key.method is set and empty' => [
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
                                    'key' => [
                                        'method' => '',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.decryption.key.hash_algorithm is set and empty' => [
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
                                    'key' => [
                                        'hash_algorithm' => '',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.decryption.key.salt is set and empty' => [
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
                                    'key' => [
                                        'salt' => '',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.decryption.key.cost is set and not an integer' => [
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
                                    'key' => [
                                        'cost' => 'not an integer',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'algorithms.#.decryption.key.cost is set and < 1' => [
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
                                    'key' => [
                                        'cost' => 0,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
