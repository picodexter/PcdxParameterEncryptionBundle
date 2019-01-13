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

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Key\Transformer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer\Base64DecoderKeyTransformer;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\Base64DecoderInterface;

class Base64DecoderKeyTransformerTest extends TestCase
{
    /**
     * @var Base64DecoderInterface|MockObject
     */
    private $base64Decoder;

    /**
     * @var Base64DecoderKeyTransformer
     */
    private $transformer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->base64Decoder = $this->createBase64DecoderInterfaceMock();

        $this->transformer = new Base64DecoderKeyTransformer($this->base64Decoder);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->transformer = null;
        $this->base64Decoder = null;
    }

    /**
     * @param bool $base64Encoded
     * @param bool $expectedResult
     *
     * @dataProvider provideAppliesForData
     */
    public function testAppliesForSuccess($base64Encoded, $expectedResult)
    {
        $key = 'some key';

        $keyConfig = $this->createKeyConfiguration();

        $keyConfig->setBase64Encoded($base64Encoded);

        $result = $this->transformer->appliesFor($key, $keyConfig);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * Data provider.
     */
    public function provideAppliesForData()
    {
        return [
            'match' => [
                true,
                true,
            ],
            'no match' => [
                false,
                false,
            ],
        ];
    }

    public function testTransformSuccess()
    {
        $key = 'some key';
        $prepTransfKey = 'transformed key';

        $keyConfig = $this->createKeyConfiguration();

        $this->base64Decoder->expects($this->once())
            ->method('decode')
            ->with($this->identicalTo($key))
            ->will($this->returnValue($prepTransfKey));

        $transformedKey = $this->transformer->transform($key, $keyConfig);

        $this->assertSame($prepTransfKey, $transformedKey);
    }

    /**
     * Create mock for Base64DecoderInterface.
     *
     * @return Base64DecoderInterface|MockObject
     */
    private function createBase64DecoderInterfaceMock()
    {
        return $this->getMockBuilder(Base64DecoderInterface::class)->getMock();
    }

    /**
     * Create key configuration.
     *
     * @return KeyConfiguration
     */
    private function createKeyConfiguration()
    {
        $keyConfig = new KeyConfiguration();

        return $keyConfig;
    }
}
