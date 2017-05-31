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

use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\Base64Encoder;

class Base64EncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed  $plainValue
     * @param string $expectedValue
     *
     * @dataProvider provideEncodeData
     */
    public function testEncodeSuccess($plainValue, $expectedValue)
    {
        $encoder = new Base64Encoder();

        $encodedValue = $encoder->encode($plainValue);

        $this->assertSame($expectedValue, $encodedValue);
    }

    /**
     * Data provider.
     */
    public function provideEncodeData()
    {
        return [
            'empty' => [
                '',
                '',
            ],
            'simple data' => [
                'test',
                'dGVzdA==',
            ],
            'data with UTF-8 characters' => [
                'string with ✓ UTF-8 character',
                'c3RyaW5nIHdpdGgg4pyTIFVURi04IGNoYXJhY3Rlcg==',
            ],
            'integer' => [
                123,
                'MTIz', // 123
            ],
            'false' => [
                false,
                '',
            ],
            'true' => [
                true,
                'MQ==', // 1
            ],
        ];
    }
}
