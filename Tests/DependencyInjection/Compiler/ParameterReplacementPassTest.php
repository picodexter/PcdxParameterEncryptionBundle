<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Compiler;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\ParameterReplacementPass;
use Picodexter\ParameterEncryptionBundle\Replacement\ParameterReplacerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ParameterReplacementPassTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessSuccess()
    {
        $pass = new ParameterReplacementPass();

        $parameterBag = new ParameterBag();

        $container = $this->createContainerBuilderMock();
        $passContainer = $this->createContainerBuilderMock();
        $parameterReplacer = $this->createParameterReplacerInterfaceMock();

        $pass->setPassContainer($passContainer);

        $container->expects($this->once())
            ->method('getParameterBag')
            ->with()
            ->will($this->returnValue($parameterBag));

        $passContainer->expects($this->once())
            ->method('get')
            ->with($this->identicalTo('pcdx_parameter_encryption.replacement.parameter_replacer'))
            ->will($this->returnValue($parameterReplacer));

        $parameterReplacer->expects($this->once())
            ->method('processParameterBag')
            ->with($this->identicalTo($parameterBag));

        $pass->process($container);
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
     * Create mock for ParameterReplacerInterface.
     *
     * @return ParameterReplacerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createParameterReplacerInterfaceMock()
    {
        return $this->getMockBuilder(ParameterReplacerInterface::class)->getMock();
    }
}
