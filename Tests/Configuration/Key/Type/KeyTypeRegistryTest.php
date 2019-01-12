<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Configuration\Key\Type;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\GeneratedKeyType;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\KeyTypeInterface;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\KeyTypeRegistry;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\StaticKeyType;
use stdClass;

class KeyTypeRegistryTest extends TestCase
{
    /**
     * @var KeyTypeRegistry
     */
    private $registry;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->registry = new KeyTypeRegistry([]);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->registry = null;
    }

    /**
     * @param array $keyTypes
     * @param int   $expectedCount
     *
     * @dataProvider provideKeyTypesData
     */
    public function testConstructorSuccess(array $keyTypes, $expectedCount)
    {
        $registry = new KeyTypeRegistry($keyTypes);

        $this->assertCount($expectedCount, $registry->getKeyTypes());
    }

    /**
     * Data provider.
     */
    public function provideKeyTypesData()
    {
        return [
            'empty' => [
                [],
                0,
            ],
            'empty - invalid data' => [
                [
                    1,
                    2,
                    'string',
                    new stdClass(),
                ],
                0,
            ],
            'mixed' => [
                [
                    1,
                    false,
                    new StaticKeyType(),
                    true,
                    new GeneratedKeyType(),
                    'a string',
                    12.34,
                ],
                2,
            ],
            'duplicates' => [
                [
                    new StaticKeyType(),
                    new GeneratedKeyType(),
                    new GeneratedKeyType(),
                ],
                2,
            ],
        ];
    }

    public function testAddSuccessExist()
    {
        $keyTypeName = 'the_key_type_name';

        $keyType = $this->createKeyTypeInterfaceMock();

        $keyType->expects($this->exactly(3))
            ->method('getName')
            ->with()
            ->will($this->returnValue($keyTypeName));

        $this->assertCount(0, $this->registry->getKeyTypes());

        $this->registry->add($keyType);

        $this->assertCount(1, $this->registry->getKeyTypes());

        $this->registry->add($keyType);

        $this->assertCount(1, $this->registry->getKeyTypes());
    }

    public function testAddSuccessNotExist()
    {
        $keyTypeName = 'the_key_type_name';

        $keyType = $this->createKeyTypeInterfaceMock();

        $keyType->expects($this->exactly(2))
            ->method('getName')
            ->with()
            ->will($this->returnValue($keyTypeName));

        $this->assertCount(0, $this->registry->getKeyTypes());

        $this->registry->add($keyType);

        $this->assertCount(1, $this->registry->getKeyTypes());
        $this->assertTrue($this->registry->has($keyTypeName));
    }

    public function testGetSuccessExist()
    {
        $preparedKeyType = new StaticKeyType();

        $this->registry->add($preparedKeyType);

        $foundKeyType = $this->registry->get(StaticKeyType::TYPE_NAME);

        $this->assertSame($preparedKeyType, $foundKeyType);
    }

    public function testGetSuccessNotExist()
    {
        $foundKeyType = $this->registry->get(StaticKeyType::TYPE_NAME);

        $this->assertNull($foundKeyType);
    }

    public function testHasSuccessExist()
    {
        $this->registry->add(new StaticKeyType());

        $this->assertTrue($this->registry->has(StaticKeyType::TYPE_NAME));
    }

    public function testHasSuccessNotExist()
    {
        $this->assertFalse($this->registry->has(StaticKeyType::TYPE_NAME));
    }

    /**
     * @param array $keyTypes
     * @param int   $expectedCount
     *
     * @dataProvider provideKeyTypesData
     */
    public function testGetSetKeyTypesSuccess(array $keyTypes, $expectedCount)
    {
        $this->assertCount(0, $this->registry->getKeyTypes());

        $this->registry->setKeyTypes($keyTypes);

        $this->assertCount($expectedCount, $this->registry->getKeyTypes());
    }

    public function testSetKeyTypesSuccessReplaceCompletely()
    {
        $keyType1 = new StaticKeyType();
        $keyType2 = new GeneratedKeyType();

        $this->assertCount(0, $this->registry->getKeyTypes());

        $this->registry->setKeyTypes([$keyType1]);

        $this->assertCount(1, $this->registry->getKeyTypes());

        $this->registry->setKeyTypes([$keyType2]);

        $this->assertCount(1, $this->registry->getKeyTypes());
    }

    /**
     * Create mock for KeyTypeInterface.
     *
     * @return KeyTypeInterface|MockObject
     */
    private function createKeyTypeInterfaceMock()
    {
        return $this->getMockBuilder(KeyTypeInterface::class)->getMock();
    }
}
