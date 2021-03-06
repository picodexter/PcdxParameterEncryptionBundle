<?php

declare(strict_types=1);

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\ParameterReplacementPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Replacement\ParameterReplacerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ParameterReplacementPassTest extends TestCase
{
    public function testProcessSuccess()
    {
        $pass = new ParameterReplacementPass();

        $parameterBag = new ParameterBag();

        $container = $this->createContainerBuilderMock();
        $parameterReplacer = $this->createParameterReplacerInterfaceMock();

        $container->expects($this->once())
            ->method('getParameterBag')
            ->with()
            ->will($this->returnValue($parameterBag));

        $container->expects($this->once())
            ->method('get')
            ->with($this->identicalTo(ServiceNames::PARAMETER_REPLACER))
            ->will($this->returnValue($parameterReplacer));

        $parameterReplacer->expects($this->once())
            ->method('processParameterBag')
            ->with(
                $this->identicalTo($parameterBag),
                $this->identicalTo($container)
            );

        $pass->process($container);
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['get', 'getParameterBag'])
            ->getMock();
    }

    /**
     * Create mock for ParameterReplacerInterface.
     *
     * @return ParameterReplacerInterface|MockObject
     */
    private function createParameterReplacerInterfaceMock()
    {
        return $this->getMockBuilder(ParameterReplacerInterface::class)->getMock();
    }
}
