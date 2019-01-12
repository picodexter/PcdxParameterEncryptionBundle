<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Initializer\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidatorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementPatternRegistrationHandler;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\UnknownReplacementPatternTypeException;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\Registry\ReplacementPatternTypeRegistryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ReplacementPatternRegistrationHandlerTest extends TestCase
{
    /**
     * @var BundleConfigurationValidatorInterface|MockObject
     */
    private $bundleConfigValidator;

    /**
     * @var DefinitionFactoryInterface|MockObject
     */
    private $definitionFactory;

    /**
     * @var ReplacementPatternRegistrationHandler
     */
    private $handler;

    /**
     * @var ReplacementPatternTypeRegistryInterface|MockObject
     */
    private $patternTypeRegistry;

    /**
     * @var ServiceNameGeneratorInterface|MockObject
     */
    private $serviceNameGenerator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->bundleConfigValidator = $this->createBundleConfigurationValidatorInterfaceMock();
        $this->definitionFactory = $this->createDefinitionFactoryInterfaceMock();
        $this->patternTypeRegistry = $this->createReplacementPatternTypeRegistryInterfaceMock();
        $this->serviceNameGenerator = $this->createServiceGeneratorInterfaceMock();

        $this->handler = new ReplacementPatternRegistrationHandler(
            $this->bundleConfigValidator,
            $this->definitionFactory,
            $this->patternTypeRegistry,
            $this->serviceNameGenerator
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->handler = null;
        $this->serviceNameGenerator = null;
        $this->patternTypeRegistry = null;
        $this->definitionFactory = null;
        $this->bundleConfigValidator = null;
    }

    public function testRegisterReplacementPatternsExceptionInvalidConfig()
    {
        $this->expectException(InvalidBundleConfigurationException::class);

        $bundleConfig = [];

        $container = $this->createContainerBuilderMock();

        $this->bundleConfigValidator->expects($this->once())
            ->method('assertValidBundleConfiguration')
            ->with($this->identicalTo($bundleConfig))
            ->will($this->throwException(new InvalidBundleConfigurationException()));

        $this->handler->registerReplacementPatterns($bundleConfig, $container);
    }

    public function testRegisterReplacementPatternsExceptionUnknownReplacementPatternType()
    {
        $this->expectException(UnknownReplacementPatternTypeException::class);

        $unknownPatternType = 'nonexistent_example';
        $bundleConfig = [
            'algorithms' => [
                [
                    'id' => 'algo_01',
                    'pattern' => [
                        'type' => $unknownPatternType,
                    ],
                ],
            ],
        ];

        $container = $this->createContainerBuilderMock();

        $this->patternTypeRegistry->expects($this->once())
            ->method('has')
            ->with($this->identicalTo($unknownPatternType))
            ->will($this->returnValue(false));

        $this->handler->registerReplacementPatterns($bundleConfig, $container);
    }

    public function testRegisterReplacementPatternsSuccessEmpty()
    {
        $container = $this->createContainerBuilderMock();

        $container->expects($this->once())
            ->method('addDefinitions')
            ->with($this->identicalTo([]));

        $this->handler->registerReplacementPatterns(
            [
                'algorithms' => [],
            ],
            $container
        );
    }

    public function testRegisterReplacementPatternsSuccessThreeDefinitions()
    {
        $preparedAlgorithmIds = [
            'algo_01',
            'algo_02',
            'algo_03',
        ];
        $preparedDefinitions = [
            $preparedAlgorithmIds[0] => $this->createDefitionMock(),
            $preparedAlgorithmIds[1] => $this->createDefitionMock(),
            $preparedAlgorithmIds[2] => $this->createDefitionMock(),
        ];

        $container = $this->createContainerBuilderMock();

        $this->patternTypeRegistry->expects($this->exactly(3))
            ->method('has')
            ->will($this->returnValue(true));

        $this->serviceNameGenerator->expects($this->exactly(3))
            ->method('getReplacementPatternServiceNameForAlgorithm')
            ->will($this->onConsecutiveCalls(
                $preparedAlgorithmIds[0],
                $preparedAlgorithmIds[1],
                $preparedAlgorithmIds[2]
            ));

        $this->definitionFactory->expects($this->exactly(3))
            ->method('createDefinition')
            ->will($this->onConsecutiveCalls(
                $preparedDefinitions[$preparedAlgorithmIds[0]],
                $preparedDefinitions[$preparedAlgorithmIds[1]],
                $preparedDefinitions[$preparedAlgorithmIds[2]]
            ));

        $container->expects($this->once())
            ->method('addDefinitions')
            ->with($this->identicalTo($preparedDefinitions));

        $this->handler->registerReplacementPatterns(
            [
                'algorithms' => [
                    [
                        'id' => $preparedAlgorithmIds[0],
                        'pattern' => [
                            'type' => 'pattern_type_01',
                            'arguments' => [],
                        ],
                    ],
                    [
                        'id' => $preparedAlgorithmIds[1],
                        'pattern' => [
                            'type' => 'pattern_type_02',
                            'arguments' => [],
                        ],
                    ],
                    [
                        'id' => $preparedAlgorithmIds[2],
                        'pattern' => [
                            'type' => 'pattern_type_03',
                            'arguments' => [],
                        ],
                    ],
                ],
            ],
            $container
        );
    }

    /**
     * Create mock for BundleConfigurationValidatorInterface.
     *
     * @return BundleConfigurationValidatorInterface|MockObject
     */
    private function createBundleConfigurationValidatorInterfaceMock()
    {
        return $this->getMockBuilder(BundleConfigurationValidatorInterface::class)->getMock();
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['addDefinitions', 'get'])
            ->getMock();
    }

    /**
     * Create mock for DefinitionFactoryInterface.
     *
     * @return DefinitionFactoryInterface|MockObject
     */
    private function createDefinitionFactoryInterfaceMock()
    {
        return $this->getMockBuilder(DefinitionFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for Definition.
     *
     * @return Definition|MockObject
     */
    private function createDefitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }

    /**
     * Create mock for ReplacementPatternTypeRegistryInterface.
     *
     * @return ReplacementPatternTypeRegistryInterface|MockObject
     */
    private function createReplacementPatternTypeRegistryInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternTypeRegistryInterface::class)->getMock();
    }

    /**
     * Create mock for ServiceNameGeneratorInterface.
     *
     * @return ServiceNameGeneratorInterface|MockObject
     */
    private function createServiceGeneratorInterfaceMock()
    {
        return $this->getMockBuilder(ServiceNameGeneratorInterface::class)->getMock();
    }
}
