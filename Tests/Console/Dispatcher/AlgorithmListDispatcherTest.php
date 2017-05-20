<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Dispatcher;

use Picodexter\ParameterEncryptionBundle\Console\Dispatcher\AlgorithmListDispatcher;
use Picodexter\ParameterEncryptionBundle\Console\Helper\TableFactoryInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\AlgorithmListProcessorInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AlgorithmListDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlgorithmListDispatcher
     */
    private $dispatcher;

    /**
     * @var AlgorithmListProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $processor;

    /**
     * @var TableFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $tableFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->processor = $this->createAlgorithmListProcessorInterfaceMock();
        $this->tableFactory = $this->createTableFactoryInterfaceMock();

        $this->dispatcher = new AlgorithmListDispatcher($this->processor, $this->tableFactory);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->dispatcher = null;
        $this->tableFactory = null;
        $this->processor = null;
    }

    public function testDispatchToProcessor()
    {
        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();
        $table = $this->createTableMock();

        $this->tableFactory->expects($this->once())
            ->method('createTable')
            ->with($this->identicalTo($output))
            ->will($this->returnValue($table));

        $this->processor->expects($this->once())
            ->method('renderAlgorithmListTable')
            ->with($this->identicalTo($table));

        $this->dispatcher->dispatchToProcessor($input, $output);
    }

    /**
     * Create mock for AlgorithmListProcessorInterface.
     *
     * @return AlgorithmListProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createAlgorithmListProcessorInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmListProcessorInterface::class)->getMock();
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

    /**
     * Create mock for TableFactoryInterface.
     *
     * @return TableFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createTableFactoryInterfaceMock()
    {
        return $this->getMockBuilder(TableFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for Table.
     *
     * @return Table|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createTableMock()
    {
        return $this->getMockBuilder(Table::class)->disableOriginalConstructor()->getMock();
    }
}
