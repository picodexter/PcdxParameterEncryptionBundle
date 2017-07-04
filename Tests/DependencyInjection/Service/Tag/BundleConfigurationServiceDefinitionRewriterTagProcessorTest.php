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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\BundleConfigurationServiceDefinitionRewriterTagProcessor;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class BundleConfigurationServiceDefinitionRewriterTagProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BundleConfigurationServiceDefinitionRewriterTagProcessor
     */
    private $processor;

    /**
     * @var ReferenceFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
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

    /**
     * @param array $taggedServiceIds
     * @param array $preparedReferences
     * @param array $expectedRegistryArgs
     *
     * @dataProvider provideProcessData
     */
    public function testProcessSuccess(array $taggedServiceIds, array $preparedReferences, array $expectedRegistryArgs)
    {
        $prepRegistryArgs = [
            [],
        ];

        $serviceIdConstraints = [];
        foreach (array_keys($taggedServiceIds) as $taggedServiceId) {
            $serviceIdConstraints[] = $this->identicalTo($taggedServiceId);
        }

        $container = $this->createContainerBuilderMock();
        $registryDefinition = $this->createDefinitionMock();

        $container->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with($this->identicalTo(BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME))
            ->will($this->returnValue($taggedServiceIds));

        $mocker = $this->referenceFactory->expects($this->atLeastOnce())
            ->method('createReference');
        call_user_func_array([$mocker, 'withConsecutive'], $serviceIdConstraints);
        call_user_func_array([$mocker, 'willReturnOnConsecutiveCalls'], $preparedReferences);

        $container->expects($this->once())
            ->method('getDefinition')
            ->with($this->identicalTo(ServiceNames::BUNDLE_CONFIGURATION_SERVICE_DEFINITION_REWRITER_REGISTRY))
            ->will($this->returnValue($registryDefinition));

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
            'success - 1 rewriter' => [
                [
                    'some_service_1' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                        ],
                    ],
                ],
                [
                    $reference1,
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
                        ],
                    ],
                    'some_service_2' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                        ],
                    ],
                    'some_service_3' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                        ],
                    ],
                ],
                [
                    $reference1,
                    $reference2,
                    $reference3,
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
                            'priority' => '-200',
                        ],
                    ],
                    'wolf' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'priority' => '3000',
                        ],
                    ],
                    'alpaca' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                        ],
                    ],
                    'dog' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
                            'priority' => '3000',
                        ],
                    ],
                    'elk' => [
                        [
                            'name' => BundleConfigurationServiceDefinitionRewriterTagProcessor::TAG_NAME,
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
                    [
                        $reference2,
                        $reference4,
                        $reference3,
                        $reference5,
                        $reference1,
                    ],
                ],
            ],
        ];
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['findTaggedServiceIds', 'getDefinition'])
            ->getMock();
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

    /**
     * Create mock for ReferenceFactoryInterface.
     *
     * @return ReferenceFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReferenceFactoryInterfaceMock()
    {
        return $this->getMockBuilder(ReferenceFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for Reference.
     *
     * @return Reference|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReferenceMock()
    {
        return $this->getMockBuilder(Reference::class)->disableOriginalConstructor()->getMock();
    }
}
