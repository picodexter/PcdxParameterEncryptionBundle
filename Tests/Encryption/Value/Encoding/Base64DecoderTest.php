<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Value\Encoding;

use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\Base64Decoder;

class Base64DecoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Base64Decoder
     */
    private $decoder;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->decoder = new Base64Decoder();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->decoder = null;
    }

    /**
     * @param mixed $encodedValue
     *
     * @dataProvider provideInvalidEncodedData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Encryption\InvalidBase64ValueException
     */
    public function testDecodeExceptionInvalidBase64Data($encodedValue)
    {
        $this->decoder->decode($encodedValue);
    }

    /**
     * Data provider.
     */
    public function provideInvalidEncodedData()
    {
        return [
            'true' => [
                true,
            ],
            'random string' => [
                '11111',
            ],
        ];
    }

    /**
     * @param mixed  $encodedValue
     * @param string $expectedValue
     *
     * @dataProvider provideValidEncodedData
     */
    public function testDecodeSuccess($encodedValue, $expectedValue)
    {
        $decodedValue = $this->decoder->decode($encodedValue);

        $this->assertSame($expectedValue, $decodedValue);
    }

    /**
     * Data provider.
     */
    public function provideValidEncodedData()
    {
        return [
            'empty' => [
                '',
                '',
            ],
            'simple data' => [
                'dGVzdA==',
                'test',
            ],
            'data with UTF-8 characters' => [
                'c3RyaW5nIHdpdGgg4pyTIFVURi04IGNoYXJhY3Rlcg==',
                'string with ✓ UTF-8 character',
            ],
            'false' => [
                false,
                '',
            ],
            'null' => [
                null,
                '',
            ],
        ];
    }
}
