<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Key\Transformer;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\GeneratedKeyType;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\KeyTypeInterface;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\StaticKeyType;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer\Pbkdf2PasswordBasedGeneratorKeyTransformer;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidKeyConfigurationException;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\UnknownHashAlgorithmException;

class Pbkdf2PasswordBasedGeneratorKeyTransformerTest extends TestCase
{
    /**
     * @var Pbkdf2PasswordBasedGeneratorKeyTransformer
     */
    private $transformer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->transformer = new Pbkdf2PasswordBasedGeneratorKeyTransformer();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->transformer = null;
    }

    /**
     * @param KeyTypeInterface $keyType
     * @param string           $keyMethod
     * @param bool             $expectedResult
     *
     * @dataProvider provideAppliesForData
     */
    public function testAppliesForSuccess(KeyTypeInterface $keyType, $keyMethod, $expectedResult)
    {
        $key = 'some key';

        $keyConfig = $this->createKeyConfiguration($keyType, $keyMethod);

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
                new GeneratedKeyType(),
                'pbkdf2',
                true,
            ],
            'no match - wrong key type' => [
                new StaticKeyType(),
                'pbkdf2',
                false,
            ],
            'no match - wrong key method' => [
                new GeneratedKeyType(),
                'wrong_method',
                false,
            ],
        ];
    }

    public function testTransformExceptionUnknownHashAlgorithm()
    {
        $this->expectException(UnknownHashAlgorithmException::class);

        $key = 'some key';

        $keyConfig = $this->createKeyConfiguration(new GeneratedKeyType(), 'pbkdf2');
        $keyConfig->setHashAlgorithm('unknown_hash_algorithm');
        $keyConfig->setSalt('not empty');
        $keyConfig->setCost(123);

        $this->transformer->transform($key, $keyConfig);
    }

    /**
     * @param string|null $hashAlgorithm
     * @param string|null $salt
     * @param int|null    $cost
     *
     * @dataProvider provideInvalidKeyConfigurationData
     */
    public function testTransformExceptionInvalidKeyConfiguration($hashAlgorithm, $salt, $cost)
    {
        $this->expectException(InvalidKeyConfigurationException::class);

        $key = 'some key';

        $keyConfig = $this->createKeyConfiguration(new GeneratedKeyType(), 'pbkdf2');
        $keyConfig->setHashAlgorithm($hashAlgorithm);
        $keyConfig->setSalt($salt);
        $keyConfig->setCost($cost);

        $this->transformer->transform($key, $keyConfig);
    }

    /**
     * Data provider.
     */
    public function provideInvalidKeyConfigurationData()
    {
        return [
            'empty hash algorithm' => [
                '',
                'some salt',
                123,
            ],
            'empty hash algorithm (null)' => [
                null,
                'some salt',
                123,
            ],
            'empty salt' => [
                'sha512',
                '',
                123,
            ],
            'empty salt (null)' => [
                'sha512',
                null,
                123,
            ],
            'empty cost' => [
                'sha512',
                'some salt',
                0,
            ],
            'empty cost (null)' => [
                'sha512',
                'some salt',
                null,
            ],
        ];
    }

    /**
     * @param string $hashAlgorithm
     * @param string $salt
     * @param int    $cost
     * @param string $expectedKey
     *
     * @dataProvider provideValidTransformData
     */
    public function testTransformSuccess($hashAlgorithm, $salt, $cost, $expectedKey)
    {
        $key = 'some key';

        $keyConfig = $this->createKeyConfiguration(new GeneratedKeyType(), 'pbkdf2');
        $keyConfig->setHashAlgorithm($hashAlgorithm);
        $keyConfig->setSalt($salt);
        $keyConfig->setCost($cost);

        $transformedKey = $this->transformer->transform($key, $keyConfig);

        $this->assertSame($expectedKey, base64_encode($transformedKey));
    }

    /**
     * Data provider.
     */
    public function provideValidTransformData()
    {
        return [
            'SHA512 @ 100 iterations' => [
                'sha512',
                'one_salt',
                100,
                '42RBWVHWeB096cvnzxNNFkSALeaYji4UhtaoRvCwMorcFTTsaklqbdv4sbIDfGNnai6q2U8R8jAV+hbI5dFzQQ==',
            ],
            'SHA512 @ 101 iterations' => [
                'sha512',
                'one_salt',
                101,
                'lDQw+dSUcRu2BrprvtaxrG3DLKNVGjpaVWtwEbOHZIXQHoY3CumXSk3YB9KwkhD3WvcShoY/Un4DS3dI6OFtdw==',
            ],
            'SHA512 @ 1000 iterations' => [
                'sha512',
                'some_salt',
                1000,
                '41XiOalfRXX8A+VsosJ1ZZKxGTct8t+SBV/IM6uMW3tM5fdmFvnY4sxBifQCLuuMXQ9U2pnKZbxL1wUL22nLXw==',
            ],
            'whirlpool @ 300 iterations' => [
                'whirlpool',
                'yet_another_salt',
                300,
                '/64DkfKaD4SApcGZQ/wWI8LPqJiRmKb3TaFO3EVveKwx8yFYMyOEYStfQ0FRakroeLAzaFFCMLWqUnOCzPxLwg==',
            ],
        ];
    }

    /**
     * Create key configuration.
     *
     * @param KeyTypeInterface $keyType
     * @param string           $keyMethod
     *
     * @return KeyConfiguration
     */
    private function createKeyConfiguration(KeyTypeInterface $keyType, $keyMethod)
    {
        $keyConfig = new KeyConfiguration();

        $keyConfig->setType($keyType);
        $keyConfig->setMethod($keyMethod);

        return $keyConfig;
    }
}
