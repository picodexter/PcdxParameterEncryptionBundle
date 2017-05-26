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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementSourceDecrypterInjectionHandlerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementSourceDecrypterRegistrationHandlerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\ReplacementSourceDecrypterInitializer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ReplacementSourceDecrypterInitializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReplacementSourceDecrypterInitializer
     */
    private $initializer;

    /**
     * @var ReplacementSourceDecrypterInjectionHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $injectionHandler;

    /**
     * @var ReplacementSourceDecrypterRegistrationHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $registrationHandler;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->injectionHandler = $this->createReplacementSourceDecrypterInjectionHandlerInterfaceMock();
        $this->registrationHandler = $this->createReplacementSourceDecrypterRegistrationHandlerInterfaceMock();

        $this->initializer = new ReplacementSourceDecrypterInitializer(
            $this->injectionHandler,
            $this->registrationHandler
        );
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
            'algorithms' => [],
        ];

        $container = $this->createContainerBuilderMock();

        $this->registrationHandler->expects($this->once())
            ->method('registerReplacementSourceDecrypters')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->injectionHandler->expects($this->once())
            ->method('injectReplacementSourceDecryptersIntoFetcher')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->initializer->initialize($bundleConfig, $container);
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

    /**
     * Create mock for ReplacementSourceDecrypterInjectionHandlerInterface.
     *
     * @return ReplacementSourceDecrypterInjectionHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReplacementSourceDecrypterInjectionHandlerInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementSourceDecrypterInjectionHandlerInterface::class)->getMock();
    }

    /**
     * Create mock for ReplacementSourceDecrypterRegistrationHandlerInterface.
     *
     * @return ReplacementSourceDecrypterRegistrationHandlerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReplacementSourceDecrypterRegistrationHandlerInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementSourceDecrypterRegistrationHandlerInterface::class)->getMock();
    }
}
