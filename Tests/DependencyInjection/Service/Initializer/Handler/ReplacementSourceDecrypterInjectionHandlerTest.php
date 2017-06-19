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
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementSourceDecrypterInjectionHandler;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ReplacementSourceDecrypterInjectionHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BundleConfigurationValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $bundleConfigValidator;

    /**
     * @var ReplacementSourceDecrypterInjectionHandler
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
        $this->referenceFactory = $this->createReferenceFactoryInterfaceMock();
        $this->serviceNameGenerator = $this->createServiceNameGeneratorInterfaceMock();

        $this->handler = new ReplacementSourceDecrypterInjectionHandler(
            $this->bundleConfigValidator,
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
        $this->bundleConfigValidator = null;
    }

    public function testInjectReplacementSourceDecryptersIntoFetcherExceptionInvalidConfig()
    {
        $this->expectException(InvalidBundleConfigurationException::class);

        $bundleConfig = [];

        $container = $this->createContainerBuilderMock();

        $this->bundleConfigValidator->expects($this->once())
            ->method('assertValidBundleConfiguration')
            ->with($this->identicalTo($bundleConfig))
            ->will($this->throwException(new InvalidBundleConfigurationException()));

        $this->handler->injectReplacementSourceDecryptersIntoFetcher($bundleConfig, $container);
    }

    public function testInjectReplacementSourceDecryptersIntoFetcherSuccessEmpty()
    {
        $container = $this->createContainerBuilderMock();

        $fetcherDefinition = $this->createDefinitionMock();

        $container->expects($this->once())
            ->method('getDefinition')
            ->with($this->identicalTo(ServiceNames::PARAMETER_REPLACEMENT_FETCHER))
            ->will($this->returnValue($fetcherDefinition));

        $fetcherDefinition->expects($this->once())
            ->method('replaceArgument')
            ->with(
                $this->identicalTo(0),
                $this->identicalTo([])
            );

        $this->handler->injectReplacementSourceDecryptersIntoFetcher(
            [
                'algorithms' => [],
            ],
            $container
        );
    }

    public function testInjectReplacementSourceDecryptersIntoFetcherSuccessThreeReferences()
    {
        $preparedReferences = [
            $this->createReferenceMock(),
            $this->createReferenceMock(),
            $this->createReferenceMock(),
        ];

        $container = $this->createContainerBuilderMock();
        $fetcherDefinition = $this->createDefinitionMock();

        $this->referenceFactory->expects($this->exactly(3))
            ->method('createReference')
            ->will($this->onConsecutiveCalls(
                $preparedReferences[0],
                $preparedReferences[1],
                $preparedReferences[2]
            ));

        $container->expects($this->once())
            ->method('getDefinition')
            ->with($this->identicalTo(ServiceNames::PARAMETER_REPLACEMENT_FETCHER))
            ->will($this->returnValue($fetcherDefinition));

        $fetcherDefinition->expects($this->once())
            ->method('replaceArgument')
            ->with(
                $this->identicalTo(0),
                $this->identicalTo($preparedReferences)
            );

        $this->handler->injectReplacementSourceDecryptersIntoFetcher(
            [
                'algorithms' => [
                    [
                        'id' => 'algo_01',
                    ],
                    [
                        'id' => 'algo_02',
                    ],
                    [
                        'id' => 'algo_03',
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
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['getDefinition'])
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
