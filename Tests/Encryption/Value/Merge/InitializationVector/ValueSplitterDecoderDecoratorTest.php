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

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Value\Merge\InitializationVector;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\DecoderInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\SplitValueBag;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\ValueSplitterDecoderDecorator;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\ValueSplitterInterface;

class ValueSplitterDecoderDecoratorTest extends TestCase
{
    /**
     * @var DecoderInterface|MockObject
     */
    private $decoder;

    /**
     * @var ValueSplitterDecoderDecorator
     */
    private $decorator;

    /**
     * @var ValueSplitterInterface|MockObject
     */
    private $valueSplitter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->decoder = $this->createDecoderInterfaceMock();
        $this->valueSplitter = $this->createValueSplitterInterfaceMock();

        $this->decorator = new ValueSplitterDecoderDecorator($this->decoder, $this->valueSplitter);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->decorator = null;
        $this->valueSplitter = null;
        $this->decoder = null;
    }

    public function testSplitSuccess()
    {
        $mergedValue = 'ENCODEDsome vectorsome encrypted value';
        $ivLength = 11;
        $prepUnencodedValue = 'some vectorsome encrypted value';
        $prepSplitValueBag = $this->createSplitValueBagMock();

        $this->decoder->expects($this->once())
            ->method('decode')
            ->with($this->identicalTo($mergedValue))
            ->will($this->returnValue($prepUnencodedValue));

        $this->valueSplitter->expects($this->once())
            ->method('split')
            ->with(
                $this->identicalTo($prepUnencodedValue),
                $this->identicalTo($ivLength)
            )
            ->will($this->returnValue($prepSplitValueBag));

        $splitValueBag = $this->decorator->split($mergedValue, $ivLength);

        $this->assertSame($prepSplitValueBag, $splitValueBag);
    }

    /**
     * Create mock for DecoderInterface.
     *
     * @return DecoderInterface|MockObject
     */
    private function createDecoderInterfaceMock()
    {
        return $this->getMockBuilder(DecoderInterface::class)->getMock();
    }

    /**
     * Create mock for SplitValueBag.
     *
     * @return SplitValueBag|MockObject
     */
    private function createSplitValueBagMock()
    {
        return $this->getMockBuilder(SplitValueBag::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for ValueSplitterInterface.
     *
     * @return ValueSplitterInterface|MockObject
     */
    private function createValueSplitterInterfaceMock()
    {
        return $this->getMockBuilder(ValueSplitterInterface::class)->getMock();
    }
}
