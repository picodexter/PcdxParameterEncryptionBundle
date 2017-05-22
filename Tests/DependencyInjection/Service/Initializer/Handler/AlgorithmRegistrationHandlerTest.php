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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidatorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\AlgorithmRegistrationHandler;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AlgorithmRegistrationHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BundleConfigurationValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $bundleConfigValidator;

    /**
     * @var DefinitionFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $definitionFactory;

    /**
     * @var AlgorithmRegistrationHandler
     */
    private $handler;

    /**
     * @var ReferenceFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $referenceFactory;

    /**
     * @var ServiceNameGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serviceNameGenerator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->bundleConfigValidator = $this->createBundleConfigValidatorInterfaceMock();
        $this->definitionFactory = $this->createDefinitionFactoryInterfaceMock();
        $this->referenceFactory = $this->createReferenceFactoryInterfaceMock();
        $this->serviceNameGenerator = $this->createServiceNameGeneratorInterfaceMock();

        $this->handler = new AlgorithmRegistrationHandler(
            $this->bundleConfigValidator,
            $this->definitionFactory,
            $this->referenceFactory,
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
        $this->referenceFactory = null;
        $this->definitionFactory = null;
        $this->bundleConfigValidator = null;
    }

    /**
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException
     */
    public function testRegisterAlgorithmsExceptionInvalidConfig()
    {
        $bundleConfig = [];

        $container = $this->createContainerBuilderMock();

        $this->bundleConfigValidator->expects($this->once())
            ->method('assertValidBundleConfiguration')
            ->with($this->identicalTo($bundleConfig))
            ->will($this->throwException(new InvalidBundleConfigurationException()));

        $this->handler->registerAlgorithms($bundleConfig, $container);
    }

    public function testRegisterAlgorithmsSuccessEmpty()
    {
        $container = $this->createContainerBuilderMock();

        $container->expects($this->once())
            ->method('addDefinitions')
            ->with($this->identicalTo([]));

        $this->handler->registerAlgorithms(
            [
                'algorithms' => [],
            ],
            $container
        );
    }

    public function testRegisterAlgorithmsSuccessThreeDefinitions()
    {
        $preparedServiceNames = [
            ServiceNames::ALGORITHM_CONFIGURATION_PREFIX . 'algo_01',
            ServiceNames::ALGORITHM_CONFIGURATION_PREFIX . 'algo_02',
            ServiceNames::ALGORITHM_CONFIGURATION_PREFIX . 'algo_03',
        ];
        $preparedDefinitions = [
            $preparedServiceNames[0] => $this->createDefinitionMock(),
            $preparedServiceNames[1] => $this->createDefinitionMock(),
            $preparedServiceNames[2] => $this->createDefinitionMock(),
        ];

        $container = $this->createContainerBuilderMock();

        $this->serviceNameGenerator->expects($this->exactly(3))
            ->method('getAlgorithmConfigurationServiceNameForAlgorithm')
            ->will($this->onConsecutiveCalls(
                $preparedServiceNames[0],
                $preparedServiceNames[1],
                $preparedServiceNames[2]
            ));

        $this->definitionFactory->expects($this->exactly(3))
            ->method('createDefinition')
            ->will($this->onConsecutiveCalls(
                $preparedDefinitions[$preparedServiceNames[0]],
                $preparedDefinitions[$preparedServiceNames[1]],
                $preparedDefinitions[$preparedServiceNames[2]]
            ));

        $container->expects($this->once())
            ->method('addDefinitions')
            ->with($this->identicalTo($preparedDefinitions));

        $this->handler->registerAlgorithms(
            [
                'algorithms' => [
                    [
                        'id' => 'algo_01',
                        'decryption' => [
                            'key' => null,
                            'service' => 'decryption_service_id_algo_01',
                        ],
                        'encryption' => [
                            'key' => null,
                            'service' => 'encryption_service_id_algo_01',
                        ],
                    ],
                    [
                        'id' => 'algo_02',
                        'decryption' => [
                            'key' => null,
                            'service' => 'decryption_service_id_algo_02',
                        ],
                        'encryption' => [
                            'key' => null,
                            'service' => 'encryption_service_id_algo_02',
                        ],
                    ],
                    [
                        'id' => 'algo_03',
                        'decryption' => [
                            'key' => null,
                            'service' => 'decryption_service_id_algo_03',
                        ],
                        'encryption' => [
                            'key' => null,
                            'service' => 'encryption_service_id_algo_03',
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
     * @return BundleConfigurationValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createBundleConfigValidatorInterfaceMock()
    {
        return $this->getMockBuilder(BundleConfigurationValidatorInterface::class)->getMock();
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)->getMock();
    }

    /**
     * Create mock for DefinitionFactoryInterface.
     *
     * @return DefinitionFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDefinitionFactoryInterfaceMock()
    {
        return $this->getMockBuilder(DefinitionFactoryInterface::class)->getMock();
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
     * Create mock for ServiceNameGeneratorInterface.
     *
     * @return ServiceNameGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createServiceNameGeneratorInterfaceMock()
    {
        return $this->getMockBuilder(ServiceNameGeneratorInterface::class)->getMock();
    }
}
