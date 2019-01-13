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

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Key;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyResolver;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer\KeyTransformerInterface;
use ReflectionProperty;
use stdClass;

class KeyResolverTest extends TestCase
{
    /**
     * @var KeyResolver
     */
    private $resolver;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->resolver = new KeyResolver([]);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->resolver = null;
    }

    /**
     * @param array $transformers
     * @param int   $expectedCount
     *
     * @dataProvider provideSetTransformersData
     */
    public function testConstructorSuccess(array $transformers, $expectedCount)
    {
        $resolver = new KeyResolver($transformers);

        $this->assertCount($expectedCount, $this->getTransformersFromKeyResolver($resolver));
    }

    /**
     * Data provider.
     */
    public function provideSetTransformersData()
    {
        return [
            '1 unique transformer' => [
                [
                    new KeyTransformerDummyOne(),
                ],
                1,
            ],
            '3 unique transformers' => [
                [
                    new KeyTransformerDummyOne(),
                    new KeyTransformerDummyTwo(),
                    new KeyTransformerDummyThree(),
                ],
                3,
            ],
            'only invalid transformers' => [
                [
                    1,
                    'this is a string',
                    true,
                    new stdClass(),
                ],
                0,
            ],
            'mixed 2 unique transformers' => [
                [
                    23.45,
                    new KeyTransformerDummyOne(),
                    new stdClass(),
                    new KeyTransformerDummyTwo(),
                ],
                2,
            ],
            'two pairs of identical transformers' => [
                [
                    new KeyTransformerDummyTwo(),
                    new KeyTransformerDummyOne(),
                    new KeyTransformerDummyTwo(),
                    new KeyTransformerDummyOne(),
                ],
                2,
            ],
        ];
    }

    /**
     * @param array $transformers
     * @param int   $expectedCount
     *
     * @dataProvider provideSetTransformersData
     */
    public function testSetTransformersSuccess(array $transformers, $expectedCount)
    {
        $this->resolver->setTransformers($transformers);

        $this->assertCount($expectedCount, $this->getTransformersFromKeyResolver($this->resolver));
    }

    public function testSetTransformersSuccessConsecutive()
    {
        $this->resolver->setTransformers([
            new KeyTransformerDummyOne(),
            new KeyTransformerDummyTwo(),
        ]);

        $this->assertCount(2, $this->getTransformersFromKeyResolver($this->resolver));

        $this->resolver->setTransformers([
            new KeyTransformerDummyOne(),
        ]);

        $this->assertCount(1, $this->getTransformersFromKeyResolver($this->resolver));
    }

    public function testResolveKeySuccessMatch()
    {
        $prepKey = 'this is a key';
        $prepTransformedKey = 'this is the transformed key';

        $transformer = new KeyTransformerDummyOne();
        $transformer->resultAppliesFor = true;
        $transformer->resultTransform = $prepTransformedKey;
        $keyConfig = $this->createKeyConfigurationMock();

        $this->resolver->setTransformers([$transformer]);

        $this->setUpKeyConfigGetValue($keyConfig, $prepKey);

        $result = $this->resolver->resolveKey($keyConfig);

        $this->assertSame($prepKey.'+'.$prepTransformedKey, $result);
    }

    public function testResolveKeySuccessMatchConsecutive()
    {
        $prepKey = 'this is a key';
        $prepTransfKeyOne = 'this is the first transformed key';
        $prepTransfKeyTwo = 'this is the second transformed key';

        $transformerOne = new KeyTransformerDummyOne();
        $transformerOne->resultAppliesFor = true;
        $transformerOne->resultTransform = $prepTransfKeyOne;
        $transformerTwo = new KeyTransformerDummyTwo();
        $transformerTwo->resultAppliesFor = true;
        $transformerTwo->resultTransform = $prepTransfKeyTwo;

        $keyConfig = $this->createKeyConfigurationMock();

        $this->resolver->setTransformers([
            $transformerOne,
            $transformerTwo,
        ]);

        $this->setUpKeyConfigGetValue($keyConfig, $prepKey);

        $result = $this->resolver->resolveKey($keyConfig);

        $this->assertSame($prepKey.'+'.$prepTransfKeyOne.'+'.$prepTransfKeyTwo, $result);
    }

    public function testResolveKeySuccessMatchMixed()
    {
        $prepKey = 'this is a key';
        $prepTransfKeyTwo = 'this is the second transformed key';

        $transformerOne = new KeyTransformerDummyOne();
        $transformerOne->resultAppliesFor = false;
        $transformerTwo = new KeyTransformerDummyTwo();
        $transformerTwo->resultAppliesFor = true;
        $transformerTwo->resultTransform = $prepTransfKeyTwo;

        $keyConfig = $this->createKeyConfigurationMock();

        $this->resolver->setTransformers([
            $transformerOne,
            $transformerTwo,
        ]);

        $this->setUpKeyConfigGetValue($keyConfig, $prepKey);

        $result = $this->resolver->resolveKey($keyConfig);

        $this->assertSame($prepKey.'+'.$prepTransfKeyTwo, $result);
    }

    public function testResolveKeySuccessNoMatch()
    {
        $prepKey = 'this is a key';

        $transformer = new KeyTransformerDummyOne();
        $transformer->resultAppliesFor = false;

        $keyConfig = $this->createKeyConfigurationMock();

        $this->resolver->setTransformers([$transformer]);

        $this->setUpKeyConfigGetValue($keyConfig, $prepKey);

        $result = $this->resolver->resolveKey($keyConfig);

        $this->assertSame($prepKey, $result);
    }

    /**
     * Create mock for KeyConfiguration.
     *
     * @return KeyConfiguration|MockObject
     */
    private function createKeyConfigurationMock()
    {
        return $this->getMockBuilder(KeyConfiguration::class)->getMock();
    }

    /**
     * Get transformers from KeyResolver.
     *
     * @param KeyResolver $keyResolver
     *
     * @return KeyTransformerInterface[]
     */
    private function getTransformersFromKeyResolver(KeyResolver $keyResolver)
    {
        $reflectionProperty = new ReflectionProperty(KeyResolver::class, 'transformers');

        $reflectionProperty->setAccessible(true);

        $transformers = $reflectionProperty->getValue($keyResolver);

        return $transformers;
    }

    /**
     * Set up KeyConfiguration: getValue.
     *
     * @param KeyConfiguration|MockObject $keyConfig
     * @param string                      $keyOrPassword
     */
    private function setUpKeyConfigGetValue($keyConfig, $keyOrPassword)
    {
        $keyConfig->expects($this->once())
            ->method('getValue')
            ->with()
            ->will($this->returnValue($keyOrPassword));
    }
}
