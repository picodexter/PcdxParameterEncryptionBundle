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
use Picodexter\ParameterEncryptionBundle\Command\EncryptCommand;
use Picodexter\ParameterEncryptionBundle\Console\Dispatcher\EncryptDispatcherInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EncryptCommandTest extends TestCase
{
    public function testExecuteSuccess()
    {
        $dispatcher = $this->createEncryptDispatcherInterfaceMock();

        $command = new EncryptCommand($dispatcher);

        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();

        $dispatcher->expects($this->once())
            ->method('dispatchToProcessor')
            ->with(
                $this->identicalTo($input),
                $this->identicalTo($output)
            );

        $command->run($input, $output);
    }

    /**
     * Create mock for EncryptDispatcherInterface.
     *
     * @return EncryptDispatcherInterface|MockObject
     */
    private function createEncryptDispatcherInterfaceMock()
    {
        return $this->getMockBuilder(EncryptDispatcherInterface::class)->getMock();
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
