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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\KeyNotEmptyServiceTagPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\KeyNotEmptyTagProcessorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class KeyNotEmptyServiceTagPassTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessSuccess()
    {
        $pass = new KeyNotEmptyServiceTagPass();

        $container = $this->createContainerBuilderMock();
        $processor = $this->createKeyNotEmptyTagProcessorInterfaceMock();

        $container->expects($this->once())
            ->method('get')
            ->with($this->identicalTo(ServiceNames::SERVICE_TAG_PROCESSOR_KEY_NOT_EMPTY))
            ->will($this->returnValue($processor));

        $processor->expects($this->once())
            ->method('process')
            ->with($this->identicalTo($container));

        $pass->process($container);
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
     * Create mock for KeyNotEmptyTagProcessorInterface.
     *
     * @return KeyNotEmptyTagProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyNotEmptyTagProcessorInterfaceMock()
    {
        return $this->getMockBuilder(KeyNotEmptyTagProcessorInterface::class)->getMock();
    }
}
