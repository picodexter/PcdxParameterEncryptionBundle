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

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\GeneratedKeyType;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\KeyTypeInterface;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\StaticKeyType;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer\BcryptPasswordBasedGeneratorKeyTransformer;

class BcryptPasswordBasedGeneratorKeyTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BcryptPasswordBasedGeneratorKeyTransformer
     */
    private $transformer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->transformer = new BcryptPasswordBasedGeneratorKeyTransformer();
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
                'bcrypt',
                true,
            ],
            'no match - wrong key type' => [
                new StaticKeyType(),
                'bcrypt',
                false,
            ],
            'no match - wrong key method' => [
                new GeneratedKeyType(),
                'wrong_method',
                false,
            ],
        ];
    }

    /**
     * @param string|null $salt
     * @param int|null    $cost
     *
     * @dataProvider provideInvalidKeyConfigurationData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidKeyConfigurationException
     */
    public function testTransformExceptionInvalidKeyConfiguration($salt, $cost)
    {
        $key = 'some key';

        $keyConfig = $this->createKeyConfiguration(new GeneratedKeyType(), 'bcrypt');
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
            'empty salt' => [
                '',
                123,
            ],
            'empty salt (null)' => [
                null,
                123,
            ],
            'empty cost' => [
                'some salt',
                0,
            ],
            'empty cost (null)' => [
                'some salt',
                null,
            ],
        ];
    }

    /**
     * @param string $salt
     * @param int    $cost
     * @param string $expectedKey
     *
     * @dataProvider provideValidTransformData
     */
    public function testTransformSuccess($salt, $cost, $expectedKey)
    {
        $key = 'some key';

        $keyConfig = $this->createKeyConfiguration(new GeneratedKeyType(), 'bcrypt');
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
            'cost = 5' => [
                'this_is_a_long_enough_salt',
                5,
                'JDJ5JDA1JGRHaHBjMTlwYzE5aFgyeHZibWRmWk9udlFGM3Q0blU1RVNXTGsxTkMvcy9hOXBVQVEyLlRt',
            ],
            'cost = 5, different salt' => [
                'different_salt_entirely',
                5,
                'JDJ5JDA1JFpHbG1abVZ5Wlc1MFgzTmhiSFJmWk9ES05SUEJMU0pXSllSU0lveWd5TDVjV3AxT0NaYUFl',
            ],
            'cost = 10' => [
                'this_is_a_long_enough_salt',
                10,
                'JDJ5JDEwJGRHaHBjMTlwYzE5aFgyeHZibWRmWk9yb3JYUXl6bldMZzI5emIyMnEuOWhQNnZzdWtOZ2Zh',
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
