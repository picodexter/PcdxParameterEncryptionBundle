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

namespace Picodexter\ParameterEncryptionBundle\Tests\Configuration\Key;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\GeneratedKeyType;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\StaticKeyType;

class KeyConfigurationTest extends TestCase
{
    /**
     * @var KeyConfiguration
     */
    private $keyConfig;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->keyConfig = new KeyConfiguration();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->keyConfig = null;
    }

    /**
     * @param mixed $base64Encoded
     * @param bool  $expectedResult
     *
     * @dataProvider provideBase64EncodedData
     */
    public function testIsSetBase64EncodedSuccess($base64Encoded, $expectedResult)
    {
        $this->assertFalse($this->keyConfig->isBase64Encoded());

        $this->keyConfig->setBase64Encoded($base64Encoded);

        $this->assertSame($expectedResult, $this->keyConfig->isBase64Encoded());
    }

    /**
     * Data provider.
     */
    public function provideBase64EncodedData()
    {
        return [
            'null' => [
                null,
                false,
            ],
            'false' => [
                false,
                false,
            ],
            'true' => [
                true,
                true,
            ],
            'string' => [
                '123abc',
                true,
            ],
            'int' => [
                1234,
                true,
            ],
            'float' => [
                12.34,
                true,
            ],
        ];
    }

    /**
     * @param mixed    $preparedCost
     * @param int|null $expectedCost
     *
     * @dataProvider provideCostData
     */
    public function testGetSetCostSuccess($preparedCost, $expectedCost)
    {
        $this->assertNull($this->keyConfig->getCost());

        $this->keyConfig->setCost($preparedCost);

        $this->assertSame($expectedCost, $this->keyConfig->getCost());
    }

    /**
     * Data provider.
     */
    public function provideCostData()
    {
        return [
            'null' => [
                null,
                null,
            ],
            'integer' => [
                123,
                123,
            ],
            'float' => [
                12.34,
                12,
            ],
            'true' => [
                true,
                1,
            ],
            'false' => [
                false,
                0,
            ],
            'string' => [
                '123abc',
                123,
            ],
        ];
    }

    public function testGetSetHashAlgorithmSuccess()
    {
        $preparedHashAlgo = 'hash_algo';

        $this->assertNull($this->keyConfig->getHashAlgorithm());

        $this->keyConfig->setHashAlgorithm($preparedHashAlgo);

        $this->assertSame($preparedHashAlgo, $this->keyConfig->getHashAlgorithm());
    }

    public function testGetSetMethodSuccess()
    {
        $preparedMethod = 'some_method';

        $this->assertNull($this->keyConfig->getMethod());

        $this->keyConfig->setMethod($preparedMethod);

        $this->assertSame($preparedMethod, $this->keyConfig->getMethod());
    }

    public function testGetSetSaltSuccess()
    {
        $preparedSalt = 'very salty';

        $this->assertNull($this->keyConfig->getSalt());

        $this->keyConfig->setSalt($preparedSalt);

        $this->assertSame($preparedSalt, $this->keyConfig->getSalt());
    }

    public function testGetSetTypeSuccess()
    {
        $preparedType = new GeneratedKeyType();

        $this->assertInstanceOf(StaticKeyType::class, $this->keyConfig->getType());

        $this->keyConfig->setType($preparedType);

        $this->assertSame($preparedType, $this->keyConfig->getType());
    }

    public function testGetSetValueSuccess()
    {
        $preparedValue = 'some key';

        $this->assertSame('', $this->keyConfig->getValue());

        $this->keyConfig->setValue($preparedValue);

        $this->assertSame($preparedValue, $this->keyConfig->getValue());
    }
}
