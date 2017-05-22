<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Command;

use Picodexter\ParameterEncryptionBundle\Command\DecryptCommand;
use Picodexter\ParameterEncryptionBundle\Console\Dispatcher\DecryptDispatcherInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DecryptCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteSuccess()
    {
        $dispatcher = $this->createDecryptDispatcherInterfaceMock();

        $command = new DecryptCommand($dispatcher);

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
     * Create mock for DecryptDispatcherInterface.
     *
     * @return DecryptDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDecryptDispatcherInterfaceMock()
    {
        return $this->getMockBuilder(DecryptDispatcherInterface::class)->getMock();
    }

    /**
     * Create mock for InputInterface.
     *
     * @return InputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createInputInterfaceMock()
    {
        return $this->getMockBuilder(InputInterface::class)->getMock();
    }

    /**
     * Create mock for OutputInterface.
     *
     * @return OutputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createOutputInterfaceMock()
    {
        return $this->getMockBuilder(OutputInterface::class)->getMock();
    }
}
