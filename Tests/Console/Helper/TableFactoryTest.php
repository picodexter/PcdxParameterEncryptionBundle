<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Helper;

use Picodexter\ParameterEncryptionBundle\Console\Helper\TableFactory;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class TableFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TableFactory
     */
    private $factory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->factory = new TableFactory();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->factory = null;
    }

    public function testCreateTableSuccess()
    {
        $output = $this->createOutputInterfaceMock();

        $table = $this->factory->createTable($output);

        $this->assertInstanceOf(Table::class, $table);
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
