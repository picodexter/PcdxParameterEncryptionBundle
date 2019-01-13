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

namespace Picodexter\ParameterEncryptionBundle\Tests\Command;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Command\AlgorithmListCommand;
use Picodexter\ParameterEncryptionBundle\Console\Dispatcher\AlgorithmListDispatcherInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AlgorithmListCommandTest extends TestCase
{
    public function testRunSuccess()
    {
        $dispatcher = $this->createAlgorithmListDispatcherInterfaceMock();
        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();

        $command = new AlgorithmListCommand($dispatcher);

        $dispatcher->expects($this->once())
            ->method('dispatchToProcessor')
            ->with(
                $this->identicalTo($input),
                $this->identicalTo($output)
            );

        $command->run($input, $output);
    }

    /**
     * Create mock for AlgorithmListDispatcherInterface.
     *
     * @return AlgorithmListDispatcherInterface|MockObject
     */
    private function createAlgorithmListDispatcherInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmListDispatcherInterface::class)->getMock();
    }

    /**
     * Create mock for InputInterface.
     *
     * @return InputInterface|MockObject
     */
    private function createInputInterfaceMock()
    {
        return $this->getMockBuilder(InputInterface::class)->getMock();
    }

    /**
     * Create mock for OutputInterface.
     *
     * @return OutputInterface|MockObject
     */
    private function createOutputInterfaceMock()
    {
        return $this->getMockBuilder(OutputInterface::class)->getMock();
    }
}
