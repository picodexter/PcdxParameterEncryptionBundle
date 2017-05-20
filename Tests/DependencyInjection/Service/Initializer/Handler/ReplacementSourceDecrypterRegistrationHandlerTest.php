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
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementSourceDecrypterRegistrationHandler;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ReplacementSourceDecrypterRegistrationHandlerTest extends \PHPUnit_Framework_TestCase
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
     * @var ReplacementSourceDecrypterRegistrationHandler
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
        $this->bundleConfigValidator = $this->createBundleConfigurationValidatorInterfaceMock();
        $this->definitionFactory = $this->createDefinitionFactoryInterfaceMock();
        $this->referenceFactory = $this->createReferenceFactoryInterfaceMock();
        $this->serviceNameGenerator = $this->createServiceNameGeneratorInterfaceMock();

        $this->handler = new ReplacementSourceDecrypterRegistrationHandler(
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
    public function testRegisterReplacementSourceDecryptersExceptionInvalidConfig()
    {
        $bundleConfig = [];

        $container = $this->createContainerBuilderMock();

        $this->bundleConfigValidator->expects($this->once())
            ->method('assertValidBundleConfiguration')
            ->with($this->identicalTo($bundleConfig))
            ->will($this->throwException(new InvalidBundleConfigurationException()));

        $this->handler->registerReplacementSourceDecrypters($bundleConfig, $container);
    }

    public function testRegisterReplacementSourceDecryptersSuccessEmpty()
    {
        $container = $this->createContainerBuilderMock();

        $container->expects($this->once())
            ->method('addDefinitions')
            ->with($this->identicalTo([]));

        $this->handler->registerReplacementSourceDecrypters(
            [
                'algorithms' => [],
            ],
            $container
        );
    }

    public function testRegisterReplacementSourceDecryptersSuccessThreeDefinitions()
    {
        $preparedAlgorithmIds = [
            'algo_01',
            'algo_02',
            'algo_03',
        ];
        $preparedServiceNames = [
            ServiceNames::REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX . $preparedAlgorithmIds[0],
            ServiceNames::REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX . $preparedAlgorithmIds[1],
            ServiceNames::REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX . $preparedAlgorithmIds[2],
        ];
        $preparedDefinitions = [
            $preparedServiceNames[0] => $this->createDefinitionMock(),
            $preparedServiceNames[1] => $this->createDefinitionMock(),
            $preparedServiceNames[2] => $this->createDefinitionMock(),
        ];

        $container = $this->createContainerBuilderMock();

        $this->definitionFactory->expects($this->exactly(3))
            ->method('createDefinition')
            ->will($this->onConsecutiveCalls(
                $preparedDefinitions[$preparedServiceNames[0]],
                $preparedDefinitions[$preparedServiceNames[1]],
                $preparedDefinitions[$preparedServiceNames[2]]
            ));

        $this->serviceNameGenerator->expects($this->exactly(3))
            ->method('getReplacementsourceDecrypterServiceNameForAlgorithm')
            ->will($this->onConsecutiveCalls(
                $preparedServiceNames[0],
                $preparedServiceNames[1],
                $preparedServiceNames[2]
            ));

        $container->expects($this->once())
            ->method('addDefinitions')
            ->with($this->identicalTo($preparedDefinitions));

        $this->handler->registerReplacementSourceDecrypters(
            [
                'algorithms' => [
                    [
                        'id' => $preparedAlgorithmIds[0],
                        'decryption' => [
                            'service' => 'algo_01_decrypter_service',
                            'key' => 'secret123',
                        ],
                    ],
                    [
                        'id' => $preparedServiceNames[1],
                        'decryption' => [
                            'service' => 'algo_02_decrypter_service',
                            'key' => 'secret234',
                        ],
                    ],
                    [
                        'id' => $preparedAlgorithmIds[2],
                        'decryption' => [
                            'service' => 'algo_03_decrypter_service',
                            'key' => 'secret345',
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
    private function createBundleConfigurationValidatorInterfaceMock()
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
