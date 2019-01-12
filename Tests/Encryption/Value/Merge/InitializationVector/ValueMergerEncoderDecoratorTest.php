<?php

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
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\EncoderInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\ValueMergerEncoderDecorator;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\ValueMergerInterface;

class ValueMergerEncoderDecoratorTest extends TestCase
{
    /**
     * @var ValueMergerEncoderDecorator
     */
    private $decorator;

    /**
     * @var EncoderInterface|MockObject
     */
    private $encoder;

    /**
     * @var ValueMergerInterface|MockObject
     */
    private $valueMerger;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->encoder = $this->createEncoderInterfaceMock();
        $this->valueMerger = $this->createValueMergerInterfaceMock();

        $this->decorator = new ValueMergerEncoderDecorator($this->encoder, $this->valueMerger);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->decorator = null;
        $this->valueMerger = null;
        $this->encoder = null;
    }

    public function testMergeSuccess()
    {
        $encryptedValue = 'an encoded encrypted value';
        $initializationVector = 'a vector';
        $preparedMergedValue = 'a vectoran encrypted value';
        $preparedEncodedValue = 'ENCODEDa vectoran encrypted value';

        $this->valueMerger->expects($this->once())
            ->method('merge')
            ->with(
                $this->identicalTo($encryptedValue),
                $this->identicalTo($initializationVector)
            )
            ->will($this->returnValue($preparedMergedValue));

        $this->encoder->expects($this->once())
            ->method('encode')
            ->with($this->identicalTo($preparedMergedValue))
            ->will($this->returnValue($preparedEncodedValue));

        $mergedValue = $this->decorator->merge($encryptedValue, $initializationVector);

        $this->assertSame($preparedEncodedValue, $mergedValue);
    }

    /**
     * Create mock for EncoderInterface.
     *
     * @return EncoderInterface|MockObject
     */
    private function createEncoderInterfaceMock()
    {
        return $this->getMockBuilder(EncoderInterface::class)->getMock();
    }

    /**
     * Create mock for ValueMergerInterface.
     *
     * @return ValueMergerInterface|MockObject
     */
    private function createValueMergerInterfaceMock()
    {
        return $this->getMockBuilder(ValueMergerInterface::class)->getMock();
    }
}
