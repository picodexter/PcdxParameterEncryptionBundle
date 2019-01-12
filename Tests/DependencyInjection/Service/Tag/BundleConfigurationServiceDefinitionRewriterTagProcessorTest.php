<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Tag;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\BundleConfigurationServiceDefinitionRewriterTagProcessor;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection\MissingTagAttributeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class BundleConfigurationServiceDefinitionRewriterTagProcessorTest extends TestCase
{
    /**
     * @var BundleConfigurationServiceDefinitionRewriterTagProcessor
     */
    private $processor;

    /**
     * @var ReferenceFactoryInterface|MockObject
     */
    private $referenceFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->referenceFactory = $this->createReferenceFactoryInterfaceMock();

        $this->processor = new BundleConfigurationServiceDefinitionRewriterTagProcessor($this->referenceFactory);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->processor = null;
        $this->referenceFactory = null;
    }

    public function testProcessExceptionMissingTagAttribute()
    {
        $this->expectException(MissingTagAttributeException::class);

        $taggedServiceIds = [
            'some_service' => [
                [
                    'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                ],
            ],
        ];

        $container = $this->createContainerBuilderMock();

        $this->setUpContainerFindTaggedServiceIds($container, $taggedServiceIds);

        $this->processor->process($container);
    }

    /**
     * @param array $taggedServiceIds
     * @param array $preparedReferences
     * @param array $preparedServiceDefs
     * @param array $expectedRegistryArgs
     *
     * @dataProvider provideProcessData
     */
    public function testProcessSuccess(
        array $taggedServiceIds,
        array $preparedReferences,
        array $preparedServiceDefs,
        array $expectedRegistryArgs
    ) {
        $prepRegistryArgs = [
            [],
        ];

        $serviceIdConstraints = [];
        foreach (array_keys($taggedServiceIds) as $taggedServiceId) {
            $serviceIdConstraints[] = $this->identicalTo($taggedServiceId);
        }

        /*
         * prepare extension configuration results according to number of successful calls (= prepared references)
         */
        $prepExtensionConfigs = [];
        for ($i = 0; $i < \count($taggedServiceIds); ++$i) {
            if ($i < \count($preparedReferences)) {
                $prepExtensionConfigs[] = [['some_directive' => 'some_value']];
            } else {
                $prepExtensionConfigs[] = [];
            }
        }

        $container = $this->createContainerBuilderMock();
        $registryDefinition = $this->createDefinitionMock();

        $this->setUpContainerFindTaggedServiceIds($container, $taggedServiceIds);

        $mocker = $container->expects($this->exactly(\count($taggedServiceIds)))
            ->method('getExtensionConfig');
        \call_user_func_array([$mocker, 'willReturnOnConsecutiveCalls'], $prepExtensionConfigs);

        $mocker = $this->referenceFactory->expects($this->exactly(\count($preparedReferences)))
            ->method('createReference');
        \call_user_func_array([$mocker, 'withConsecutive'], $serviceIdConstraints);
        \call_user_func_array([$mocker, 'willReturnOnConsecutiveCalls'], $preparedReferences);

        $mocker = $container->expects($this->exactly(\count($preparedReferences) + 1))
            ->method('getDefinition');
        \call_user_func_array(
            [$mocker, 'withConsecutive'],
            array_merge(
                $serviceIdConstraints,
                [$this->identicalTo(ServiceNames::BUNDLE_CONFIGURATION_SERVICE_DEFINITION_REWRITER_REGISTRY)]
            )
        );
        \call_user_func_array(
            [$mocker, 'willReturnOnConsecutiveCalls'],
            array_merge(
                $preparedServiceDefs,
                [$registryDefinition]
            )
        );

        foreach ($preparedServiceDefs as $serviceDefinition) {
            /* @var MockObject $serviceDefinition */
            $serviceDefinition->expects($this->once())
                ->method('getMethodCalls')
                ->with()
                ->will($this->returnValue([]));

            $serviceDefinition->expects($this->once())
                ->method('setMethodCalls')
                ->with($this->countOf(1));
        }

        $registryDefinition->expects($this->once())
            ->method('getArguments')
            ->with()
            ->will($this->returnValue($prepRegistryArgs));

        $registryDefinition->expects($this->once())
            ->method('setArguments')
            ->with($this->identicalTo($expectedRegistryArgs));

        $this->processor->process($container);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideProcessData()
    {
        $reference1 = $this->createReferenceMock();
        $reference2 = $this->createReferenceMock();
        $reference3 = $this->createReferenceMock();
        $reference4 = $this->createReferenceMock();
        $reference5 = $this->createReferenceMock();

        return [
            'success - empty' => [
                [],
                [],
                [],
                [[]],
            ],
            'success - 1 rewriter' => [
                [
                    'some_service_1' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                        ],
                    ],
                ],
                [
                    $reference1,
                ],
                [
                    $this->createDefinitionMock(),
                ],
                [
                    [
                        $reference1,
                    ],
                ],
            ],
            'success - 3 rewriters' => [
                [
                    'some_service_1' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                        ],
                    ],
                    'some_service_2' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                        ],
                    ],
                    'some_service_3' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                        ],
                    ],
                ],
                [
                    $reference1,
                    $reference2,
                    $reference3,
                ],
                [
                    $this->createDefinitionMock(),
                    $this->createDefinitionMock(),
                    $this->createDefinitionMock(),
                ],
                [
                    [
                        $reference1,
                        $reference2,
                        $reference3,
                    ],
                ],
            ],
            'success - 5 rewriters sorted by priority' => [
                [
                    'zebra' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                            'priority' => '-200',
                        ],
                    ],
                    'wolf' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                            'priority' => '3000',
                        ],
                    ],
                    'alpaca' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                        ],
                    ],
                    'dog' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                            'priority' => '3000',
                        ],
                    ],
                    'elk' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                        ],
                    ],
                ],
                [
                    $reference1,
                    $reference2,
                    $reference3,
                    $reference4,
                    $reference5,
                ],
                [
                    $this->createDefinitionMock(),
                    $this->createDefinitionMock(),
                    $this->createDefinitionMock(),
                    $this->createDefinitionMock(),
                    $this->createDefinitionMock(),
                ],
                [
                    [
                        $reference2,
                        $reference4,
                        $reference3,
                        $reference5,
                        $reference1,
                    ],
                ],
            ],
            'success - 3 rewriters, only 1 with matching extension config' => [
                [
                    'some_service_1' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'unknown_extension',
                        ],
                    ],
                    'some_service_2' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'some_extension',
                        ],
                    ],
                    'some_service_3' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'extension_configuration_key' => 'other_unknown_extension',
                        ],
                    ],
                ],
                [
                    $reference2,
                ],
                [
                    $this->createDefinitionMock(),
                ],
                [
                    [
                        $reference2,
                    ],
                ],
            ],
        ];
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['findTaggedServiceIds', 'getDefinition', 'getExtensionConfig'])
            ->getMock();
    }

    /**
     * Create mock for Definition.
     *
     * @return Definition|MockObject
     */
    private function createDefinitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }

    /**
     * Create mock for ReferenceFactoryInterface.
     *
     * @return ReferenceFactoryInterface|MockObject
     */
    private function createReferenceFactoryInterfaceMock()
    {
        return $this->getMockBuilder(ReferenceFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for Reference.
     *
     * @return Reference|MockObject
     */
    private function createReferenceMock()
    {
        return $this->getMockBuilder(Reference::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Set up container: findTaggedServiceIds.
     *
     * @param ContainerBuilder|MockObject $container
     * @param array                       $taggedServiceIds
     */
    private function setUpContainerFindTaggedServiceIds(ContainerBuilder $container, array $taggedServiceIds)
    {
        $container->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with($this->identicalTo(BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME))
            ->will($this->returnValue($taggedServiceIds));
    }
}
