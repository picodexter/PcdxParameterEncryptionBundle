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

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\SplitValueBag;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector\ValueSplitter;
use Picodexter\ParameterEncryptionBundle\Exception\Encryption\InvalidInitializationVectorLengthException;
use Picodexter\ParameterEncryptionBundle\Exception\Encryption\MergedValueTooShortException;

class ValueSplitterTest extends TestCase
{
    /**
     * @var ValueSplitter
     */
    private $splitter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->splitter = new ValueSplitter();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->splitter = null;
    }

    public function testSplitExceptionValueTooShort()
    {
        $this->expectException(MergedValueTooShortException::class);

        $mergedValue = 'short value';

        $this->splitter->split($mergedValue, \strlen($mergedValue));
    }

    public function testSplitExceptionIvLengthTooShort()
    {
        $this->expectException(InvalidInitializationVectorLengthException::class);

        $this->splitter->split('some value', 0);
    }

    /**
     * @param string $mergedValue
     * @param int    $ivLength
     * @param string $expectedValue
     * @param string $expectedIv
     *
     * @dataProvider provideSplitData
     */
    public function testSplitSuccess($mergedValue, $ivLength, $expectedValue, $expectedIv)
    {
        $splitValueBag = $this->splitter->split($mergedValue, $ivLength);

        $this->assertInstanceOf(SplitValueBag::class, $splitValueBag);
        $this->assertSame($expectedValue, $splitValueBag->getEncryptedValue());
        $this->assertSame($expectedIv, $splitValueBag->getInitializationVector());
    }

    /**
     * Data provider.
     */
    public function provideSplitData()
    {
        return [
            'normal' => [
                'this is the IVthis is the encrypted value',
                14,
                'this is the encrypted value',
                'this is the IV',
            ],
            'shortest possible value' => [
                'ab',
                1,
                'b',
                'a',
            ],
        ];
    }
}
