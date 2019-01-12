<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Processor;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\AlgorithmListProcessor;
use Symfony\Component\Console\Helper\Table;

class AlgorithmListProcessorTest extends TestCase
{
    /**
     * @var AlgorithmConfigurationContainerInterface|MockObject
     */
    private $algorithmConfigContainer;

    /**
     * @var AlgorithmListProcessor
     */
    private $processor;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->algorithmConfigContainer = $this->createAlgorithmConfigurationContainerInterfaceMock();

        $this->processor = new AlgorithmListProcessor($this->algorithmConfigContainer);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->processor = null;
        $this->algorithmConfigContainer = null;
    }

    public function testRenderAlgorithmListTableSuccessEmpty()
    {
        $table = $this->createTableMock();

        $this->algorithmConfigContainer->expects($this->once())
            ->method('getAlgorithmConfigurations')
            ->with()
            ->will($this->returnValue([]));

        $table->expects($this->never())
            ->method('addRow');

        $table->expects($this->once())
            ->method('render');

        $this->processor->renderAlgorithmListTable($table);
    }

    public function testRenderAlgorithmListTableSuccessThreeRows()
    {
        $preparedAlgorithms = [
            $this->createAlgorithmConfigurationMock(),
            $this->createAlgorithmConfigurationMock(),
            $this->createAlgorithmConfigurationMock(),
        ];

        $table = $this->createTableMock();

        $this->algorithmConfigContainer->expects($this->once())
            ->method('getAlgorithmConfigurations')
            ->with()
            ->will($this->returnValue($preparedAlgorithms));

        $table->expects($this->exactly(3))
            ->method('addRow');

        $table->expects($this->once())
            ->method('render');

        $this->processor->renderAlgorithmListTable($table);
    }

    /**
     * Create mock for AlgorithmConfigurationContainerInterface.
     *
     * @return AlgorithmConfigurationContainerInterface|MockObject
     */
    private function createAlgorithmConfigurationContainerInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmConfigurationContainerInterface::class)->getMock();
    }

    /**
     * Create mock for AlgorithmConfiguration.
     *
     * @return AlgorithmConfiguration|MockObject
     */
    private function createAlgorithmConfigurationMock()
    {
        return $this->getMockBuilder(AlgorithmConfiguration::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for Table.
     *
     * @return Table|MockObject
     */
    private function createTableMock()
    {
        return $this->getMockBuilder(Table::class)->disableOriginalConstructor()->getMock();
    }
}
