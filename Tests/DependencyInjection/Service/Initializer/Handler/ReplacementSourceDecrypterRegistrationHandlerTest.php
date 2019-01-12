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
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\EnvironmentPlaceholderResolverInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidatorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementSourceDecrypterRegistrationHandler;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ReplacementSourceDecrypterRegistrationHandlerTest extends TestCase
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
     * @var EnvironmentPlaceholderResolverInterface|MockObject
     */
    private $environmentPlaceholderResolver;

    /**
     * @var ReplacementSourceDecrypterRegistrationHandler
     */
    private $handler;

    /**
     * @var ReferenceFactoryInterface|MockObject
     */
    private $referenceFactory;

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
        $this->environmentPlaceholderResolver = $this->createEnvironmentPlaceholderResolverInterfaceMock();
        $this->referenceFactory = $this->createReferenceFactoryInterfaceMock();
        $this->serviceNameGenerator = $this->createServiceNameGeneratorInterfaceMock();

        $this->handler = new ReplacementSourceDecrypterRegistrationHandler(
            $this->bundleConfigValidator,
            $this->definitionFactory,
            $this->environmentPlaceholderResolver,
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
        $this->environmentPlaceholderResolver = null;
        $this->definitionFactory = null;
        $this->bundleConfigValidator = null;
    }

    public function testRegisterReplacementSourceDecryptersExceptionInvalidConfig()
    {
        $this->expectException(InvalidBundleConfigurationException::class);

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
        $prepAlgorithmIds = [
            'algo_01',
            'algo_02',
            'algo_03',
        ];
        $prepServiceNames = [
            ServiceNames::REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX.$prepAlgorithmIds[0],
            ServiceNames::REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX.$prepAlgorithmIds[1],
            ServiceNames::REPLACEMENT_SOURCE_DECRYPTER_ALGORITHM_PREFIX.$prepAlgorithmIds[2],
        ];
        $prepKeyConfDefs = [
            $this->createDefinitionMock(),
            $this->createDefinitionMock(),
            $this->createDefinitionMock(),
        ];
        $prepSourceDefs = [
            $prepServiceNames[0] => $this->createDefinitionMock(),
            $prepServiceNames[1] => $this->createDefinitionMock(),
            $prepServiceNames[2] => $this->createDefinitionMock(),
        ];

        $container = $this->createContainerBuilderMock();

        $this->definitionFactory->expects($this->exactly(6))
            ->method('createDefinition')
            ->will($this->onConsecutiveCalls(
                $prepKeyConfDefs[0],
                $prepSourceDefs[$prepServiceNames[0]],
                $prepKeyConfDefs[1],
                $prepSourceDefs[$prepServiceNames[1]],
                $prepKeyConfDefs[2],
                $prepSourceDefs[$prepServiceNames[2]]
            ));

        $this->serviceNameGenerator->expects($this->exactly(3))
            ->method('getReplacementsourceDecrypterServiceNameForAlgorithm')
            ->will($this->onConsecutiveCalls(
                $prepServiceNames[0],
                $prepServiceNames[1],
                $prepServiceNames[2]
            ));

        $container->expects($this->once())
            ->method('addDefinitions')
            ->with($this->identicalTo($prepSourceDefs));

        $this->handler->registerReplacementSourceDecrypters(
            [
                'algorithms' => [
                    [
                        'id' => $prepAlgorithmIds[0],
                        'decryption' => [
                            'service' => 'algo_01_decrypter_service',
                            'key' => [
                                'value' => 'secret123',
                            ],
                        ],
                    ],
                    [
                        'id' => $prepServiceNames[1],
                        'decryption' => [
                            'service' => 'algo_02_decrypter_service',
                            'key' => [
                                'value' => 'secret234',
                            ],
                        ],
                    ],
                    [
                        'id' => $prepAlgorithmIds[2],
                        'decryption' => [
                            'service' => 'algo_03_decrypter_service',
                            'key' => [
                                'value' => 'secret345',
                            ],
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
            ->setMethods(['addDefinitions'])
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
    private function createDefinitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }

    /**
     * Create mock for EnvironmentPlaceholderResolverInterface.
     *
     * @return EnvironmentPlaceholderResolverInterface|MockObject
     */
    private function createEnvironmentPlaceholderResolverInterfaceMock()
    {
        return $this->getMockBuilder(EnvironmentPlaceholderResolverInterface::class)->getMock();
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
     * Create mock for ServiceNameGeneratorInterface.
     *
     * @return ServiceNameGeneratorInterface|MockObject
     */
    private function createServiceNameGeneratorInterfaceMock()
    {
        return $this->getMockBuilder(ServiceNameGeneratorInterface::class)->getMock();
    }
}
