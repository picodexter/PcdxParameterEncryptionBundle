<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Initializer;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\AlgorithmInitializer;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\AlgorithmInjectionHandlerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\AlgorithmRegistrationHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AlgorithmInitializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlgorithmInitializer
     */
    private $initializer;

    /**
     * @var AlgorithmInjectionHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $injectionHandler;

    /**
     * @var AlgorithmRegistrationHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $registrationHandler;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->injectionHandler = $this->createAlgorithmInjectionHandlerInterfaceMock();
        $this->registrationHandler = $this->createAlgorithmRegistrationHandlerInterfaceMock();
        $this->initializer = new AlgorithmInitializer($this->injectionHandler, $this->registrationHandler);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->initializer = null;
        $this->registrationHandler = null;
        $this->injectionHandler = null;
    }

    public function testInitializeSuccess()
    {
        $bundleConfig = [
            'algorithms' => []
        ];
        $container = $this->createContainerBuilderMock();

        $this->registrationHandler->expects($this->once())
            ->method('registerAlgorithms')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->injectionHandler->expects($this->once())
            ->method('injectAlgorithmConfigurationsIntoContainer')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->initializer->initialize($bundleConfig, $container);
    }

    /**
     * Create mock for AlgorithmInjectionHandlerInterface.
     *
     * @return AlgorithmInjectionHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createAlgorithmInjectionHandlerInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmInjectionHandlerInterface::class)->getMock();
    }

    /**
     * Create mock for AlgorithmRegistrationHandlerInterface.
     *
     * @return AlgorithmRegistrationHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createAlgorithmRegistrationHandlerInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmRegistrationHandlerInterface::class)->getMock();
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['get'])
            ->getMock();
    }
}
