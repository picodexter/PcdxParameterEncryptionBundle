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

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Processor;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKey;

class TransformedKeyTest extends TestCase
{
    /**
     * @var TransformedKey
     */
    private $transformedKey;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->transformedKey = new TransformedKey();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->transformedKey = null;
    }

    /**
     * @param mixed  $finalKey
     * @param string $expectedFinalKey
     *
     * @dataProvider provideStringCastOrNullData
     */
    public function testGetSetFinalKeySuccess($finalKey, $expectedFinalKey)
    {
        $this->assertSame('', $this->transformedKey->getFinalKey());

        $this->transformedKey->setFinalKey($finalKey);

        $this->assertSame($expectedFinalKey, $this->transformedKey->getFinalKey());
    }

    /**
     * Data provider.
     */
    public function provideStringCastOrNullData()
    {
        return [
            'string' => [
                'some final key',
                'some final key',
            ],
            'int' => [
                123,
                '123',
            ],
            'true' => [
                true,
                '1',
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

    /**
     * @param mixed  $finalKeyEncoded
     * @param string $expectedFinalKey
     *
     * @dataProvider provideStringCastOrNullData
     */
    public function testGetSetFinalKeyEncodedSuccess($finalKeyEncoded, $expectedFinalKey)
    {
        $this->assertSame('', $this->transformedKey->getFinalKeyEncoded());

        $this->transformedKey->setFinalKeyEncoded($finalKeyEncoded);

        $this->assertSame($expectedFinalKey, $this->transformedKey->getFinalKeyEncoded());
    }

    /**
     * @param mixed  $originalKey
     * @param string $expectedKey
     *
     * @dataProvider provideStringCastOrNullData
     */
    public function testGetSetOriginalKeySuccess($originalKey, $expectedKey)
    {
        $this->assertSame('', $this->transformedKey->getOriginalKey());

        $this->transformedKey->setOriginalKey($originalKey);

        $this->assertSame($expectedKey, $this->transformedKey->getOriginalKey());
    }

    public function testHasChangedSuccessChanged()
    {
        $this->transformedKey->setOriginalKey('value 1');
        $this->transformedKey->setFinalKey('value 2');

        $this->assertTrue($this->transformedKey->hasChanged());
    }

    public function testHasChangedSuccessNotChanged()
    {
        $this->transformedKey->setOriginalKey('value');
        $this->transformedKey->setFinalKey('value');

        $this->assertFalse($this->transformedKey->hasChanged());
    }
}
