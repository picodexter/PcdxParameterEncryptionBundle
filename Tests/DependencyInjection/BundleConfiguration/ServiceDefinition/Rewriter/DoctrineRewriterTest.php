<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\ArgumentReplacerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\DoctrineRewriter;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Definition;

class DoctrineRewriterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArgumentReplacerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $argumentReplacer;

    /**
     * @var ConfigurationInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $configuration;

    /**
     * @var DoctrineRewriter|\PHPUnit_Framework_MockObject_MockObject
     */
    private $rewriter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->argumentReplacer = $this->createArgumentReplacerInterfaceMock();
        $this->configuration = $this->createConfigurationInterfaceMock();

        $this->rewriter = new DoctrineRewriter($this->argumentReplacer, $this->configuration);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->rewriter = null;
        $this->configuration = null;
        $this->argumentReplacer = null;
    }

    /**
     * @param string $serviceId
     * @param bool   $expectedResult
     *
     * @dataProvider provideAppliesData
     */
    public function testAppliesSuccess($serviceId, $expectedResult)
    {
        $definition = $this->createDefinitionMock();
        $extensionConfig = [];

        $result = $this->rewriter->applies($serviceId, $definition, $extensionConfig);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideAppliesData()
    {
        return [
            'match' => [
                'doctrine.dbal.a_connection',
                true,
            ],
            'no match - wrong beginning' => [
                'notdoctrine.dbal.a_connection',
                false,
            ],
            'no match - wrong end' => [
                'doctrine.dbal.a_notconnection',
                false,
            ],
            'no match - too short' => [
                'doctrine.dbal._connection',
                false,
            ],
        ];
    }

    public function testGetConfigurationSuccess()
    {
        $configuration = $this->createConfigurationInterfaceMock();

        $rewriter = new DoctrineRewriter($this->argumentReplacer, $configuration);

        $this->assertSame($configuration, $rewriter->getConfiguration());
    }

    public function testGetExtensionConfigurationKeySuccess()
    {
        $this->assertSame(
            DoctrineRewriter::EXTENSION_CONFIGURATION_KEY,
            $this->rewriter->getExtensionConfigurationKey()
        );
    }

    /**
     * @param array  $connectionConfig
     * @param array  $expectedConnConfig
     *
     * @dataProvider provideProcessServiceDefinitionData
     */
    public function testProcessServiceDefinitionSuccess(array $connectionConfig, array $expectedConnConfig)
    {
        $serviceId = 'doctrine.dbal.default_connection';
        $definition = $this->createDefinitionMock();
        $extensionConfig = [
            'dbal' => [
                'connections' => [
                    'default' => $connectionConfig,
                ],
            ],
        ];

        $definition->expects($this->once())
            ->method('getArguments')
            ->with()
            ->will($this->returnValue([$connectionConfig]));

        $this->argumentReplacer->expects($this->any())
            ->method('replaceArgumentIfExists')
            ->withConsecutive(
                [$this->anything(), $this->anything(), $this->identicalTo('host')],
                [$this->anything(), $this->anything(), $this->identicalTo('port')],
                [$this->anything(), $this->anything(), $this->identicalTo('dbname')],
                [$this->anything(), $this->anything(), $this->identicalTo('user')],
                [$this->anything(), $this->anything(), $this->identicalTo('password')]
            )
            ->will($this->returnCallback(function ($serviceConnArguments, $resolvedConnConfig, $argumentKey) {
                $serviceConnArguments[$argumentKey] = 'REPLACED_VALUE';
                return $serviceConnArguments;
            }));

        $definition->expects($this->once())
            ->method('setArguments')
            ->with($this->identicalTo([$expectedConnConfig]));

        $this->rewriter->processServiceDefinition($serviceId, $definition, $extensionConfig);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideProcessServiceDefinitionData()
    {
        return [
            'success - plain connection' => [
                [
                    'driver'   => 'pdo_mysql',
                    'host'     => 'INITIAL_VALUE',
                    'port'     => 'INITIAL_VALUE',
                    'dbname'   => 'INITIAL_VALUE',
                    'user'     => 'INITIAL_VALUE',
                    'password' => 'INITIAL_VALUE',
                    'charset'  => 'UTF8',
                ],
                [
                    'driver'   => 'pdo_mysql',
                    'host'     => 'REPLACED_VALUE',
                    'port'     => 'REPLACED_VALUE',
                    'dbname'   => 'REPLACED_VALUE',
                    'user'     => 'REPLACED_VALUE',
                    'password' => 'REPLACED_VALUE',
                    'charset'  => 'UTF8',
                ],
            ],
            'success - with slave' => [
                [
                    'master' => [
                        'driver'   => 'pdo_mysql',
                        'host'     => 'INITIAL_VALUE',
                        'port'     => 'INITIAL_VALUE',
                        'dbname'   => 'INITIAL_VALUE',
                        'user'     => 'INITIAL_VALUE',
                        'password' => 'INITIAL_VALUE',
                        'charset'  => 'UTF8',
                    ],
                    'slaves' => [
                        'slave_1' => [
                            'host'     => 'INITIAL_VALUE',
                            'port'     => 'INITIAL_VALUE',
                            'dbname'   => 'INITIAL_VALUE',
                            'user'     => 'INITIAL_VALUE',
                            'password' => 'INITIAL_VALUE',
                            'charset'  => 'UTF8',
                        ],
                    ],
                ],
                [
                    'master' => [
                        'driver'   => 'pdo_mysql',
                        'host'     => 'REPLACED_VALUE',
                        'port'     => 'REPLACED_VALUE',
                        'dbname'   => 'REPLACED_VALUE',
                        'user'     => 'REPLACED_VALUE',
                        'password' => 'REPLACED_VALUE',
                        'charset'  => 'UTF8',
                    ],
                    'slaves' => [
                        'slave_1' => [
                            'host'     => 'REPLACED_VALUE',
                            'port'     => 'REPLACED_VALUE',
                            'dbname'   => 'REPLACED_VALUE',
                            'user'     => 'REPLACED_VALUE',
                            'password' => 'REPLACED_VALUE',
                            'charset'  => 'UTF8',
                        ],
                    ],
                ],
            ],
            'success - with shard' => [
                [
                    'global' => [
                        'driver'   => 'pdo_mysql',
                        'host'     => 'INITIAL_VALUE',
                        'port'     => 'INITIAL_VALUE',
                        'dbname'   => 'INITIAL_VALUE',
                        'user'     => 'INITIAL_VALUE',
                        'password' => 'INITIAL_VALUE',
                        'charset'  => 'UTF8',
                    ],
                    'shards' => [
                        'shard_1' => [
                            'id'       => 123,
                            'host'     => 'INITIAL_VALUE',
                            'port'     => 'INITIAL_VALUE',
                            'dbname'   => 'INITIAL_VALUE',
                            'user'     => 'INITIAL_VALUE',
                            'password' => 'INITIAL_VALUE',
                            'charset'  => 'UTF8',
                        ],
                    ],
                ],
                [
                    'global' => [
                        'driver'   => 'pdo_mysql',
                        'host'     => 'REPLACED_VALUE',
                        'port'     => 'REPLACED_VALUE',
                        'dbname'   => 'REPLACED_VALUE',
                        'user'     => 'REPLACED_VALUE',
                        'password' => 'REPLACED_VALUE',
                        'charset'  => 'UTF8',
                    ],
                    'shards' => [
                        'shard_1' => [
                            'id'       => 123,
                            'host'     => 'REPLACED_VALUE',
                            'port'     => 'REPLACED_VALUE',
                            'dbname'   => 'REPLACED_VALUE',
                            'user'     => 'REPLACED_VALUE',
                            'password' => 'REPLACED_VALUE',
                            'charset'  => 'UTF8',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Create mock for ArgumentReplacerInterface.
     *
     * @return ArgumentReplacerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createArgumentReplacerInterfaceMock()
    {
        return $this->getMockBuilder(ArgumentReplacerInterface::class)->getMock();
    }

    /**
     * Create mock for ConfigurationInterface.
     *
     * @return ConfigurationInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createConfigurationInterfaceMock()
    {
        return $this->getMockBuilder(ConfigurationInterface::class)->getMock();
    }

    /**
     * Create mock for Definition.
     *
     * @return Definition|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDefinitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }
}
