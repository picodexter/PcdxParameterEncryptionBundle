<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\CryptoClassDetector;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\CaesarDecrypter;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\CaesarEncrypter;
use Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection\UnknownClassException;

class CryptoClassDetectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CryptoClassDetector
     */
    private $detector;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->detector = new CryptoClassDetector();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->detector = null;
    }

    public function testIsDecrypterClassExceptionUnknownClass()
    {
        $this->expectException(UnknownClassException::class);

        $this->detector->isDecrypterClass('\\Picodexter\\ParameterEncryptionBundle\\UnknownClass');
    }

    /**
     * @param string $className
     * @param bool   $expectedResult
     *
     * @dataProvider provideIsDecrypterData
     */
    public function testIsDecrypterClassSuccess($className, $expectedResult)
    {
        $result = $this->detector->isDecrypterClass($className);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * Data provider.
     */
    public function provideIsDecrypterData()
    {
        return [
            'is a decrypter' => [
                CaesarDecrypter::class,
                true,
            ],
            'not a decrypter' => [
                CaesarEncrypter::class,
                false,
            ],
        ];
    }

    public function testIsEncrypterClassExceptionUnknownClass()
    {
        $this->expectException(UnknownClassException::class);

        $this->detector->isDecrypterClass('\\Picodexter\\ParameterEncryptionBundle\\UnknownClass');
    }

    /**
     * @param string $className
     * @param bool   $expectedResult
     *
     * @dataProvider provideIsEncrypterData
     */
    public function testIsEncrypterClassSuccess($className, $expectedResult)
    {
        $result = $this->detector->isEncrypterClass($className);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * Data provider.
     */
    public function provideIsEncrypterData()
    {
        return [
            'is an encrypter' => [
                CaesarEncrypter::class,
                true,
            ],
            'not an encrypter' => [
                CaesarDecrypter::class,
                false,
            ],
        ];
    }
}
