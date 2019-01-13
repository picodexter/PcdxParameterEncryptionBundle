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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfigurationFactory;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\KeyTypeInterface;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\Type\KeyTypeRegistryInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\UnknownKeyTypeException;

class KeyConfigurationFactoryTest extends TestCase
{
    /**
     * @var KeyConfigurationFactory
     */
    private $factory;

    /**
     * @var KeyTypeRegistryInterface|MockObject
     */
    private $keyTypeRegistry;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->keyTypeRegistry = $this->createKeyTypeRegistryInterfaceMock();

        $this->factory = new KeyConfigurationFactory($this->keyTypeRegistry);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->factory = null;
        $this->keyTypeRegistry = null;
    }

    public function testCreateKeyConfigurationExceptionInvalidType()
    {
        $this->expectException(UnknownKeyTypeException::class);

        $keyTypeName = 'invalid_key_type';

        $this->keyTypeRegistry->expects($this->once())
            ->method('has')
            ->with($this->identicalTo($keyTypeName))
            ->will($this->returnValue(false));

        $this->factory->createKeyConfiguration(['type' => $keyTypeName]);
    }

    public function testCreateKeyConfigurationSuccessBase64Encoded()
    {
        $base64Encoded = true;

        $keyConfig = $this->factory->createKeyConfiguration(['base64_encoded' => true]);

        $this->assertInstanceOf(KeyConfiguration::class, $keyConfig);
        $this->assertSame($base64Encoded, $keyConfig->isBase64Encoded());
    }

    public function testCreateKeyConfigurationSuccessCost()
    {
        $cost = 1000;

        $keyConfig = $this->factory->createKeyConfiguration(['cost' => $cost]);

        $this->assertInstanceOf(KeyConfiguration::class, $keyConfig);
        $this->assertSame($cost, $keyConfig->getCost());
    }

    public function testCreateKeyConfigurationSuccessEmpty()
    {
        $keyConfig = $this->factory->createKeyConfiguration([]);

        $this->assertInstanceOf(KeyConfiguration::class, $keyConfig);
    }

    public function testCreateKeyConfigurationSuccessHashAlgorithm()
    {
        $hashAlgorithm = 'some_hash_algo';

        $keyConfig = $this->factory->createKeyConfiguration(['hash_algorithm' => $hashAlgorithm]);

        $this->assertInstanceOf(KeyConfiguration::class, $keyConfig);
        $this->assertSame($hashAlgorithm, $keyConfig->getHashAlgorithm());
    }

    public function testCreateKeyConfigurationSuccessMethod()
    {
        $method = 'some_method';

        $keyConfig = $this->factory->createKeyConfiguration(['method' => $method]);

        $this->assertInstanceOf(KeyConfiguration::class, $keyConfig);
        $this->assertSame($method, $keyConfig->getMethod());
    }

    public function testCreateKeyConfigurationSuccessSalt()
    {
        $salt = 'some salt';

        $keyConfig = $this->factory->createKeyConfiguration(['salt' => $salt]);

        $this->assertInstanceOf(KeyConfiguration::class, $keyConfig);
        $this->assertSame($salt, $keyConfig->getSalt());
    }

    public function testCreateKeyConfigurationSuccessType()
    {
        $keyTypeName = 'valid_key_type';
        $keyType = $this->createKeyTypeInterfaceMock();

        $this->keyTypeRegistry->expects($this->once())
            ->method('has')
            ->with($this->identicalTo($keyTypeName))
            ->will($this->returnValue(true));

        $this->keyTypeRegistry->expects($this->once())
            ->method('get')
            ->with($this->identicalTo($keyTypeName))
            ->will($this->returnValue($keyType));

        $keyConfig = $this->factory->createKeyConfiguration(['type' => $keyTypeName]);

        $this->assertInstanceOf(KeyConfiguration::class, $keyConfig);
        $this->assertSame($keyType, $keyConfig->getType());
    }

    public function testCreateKeyConfigurationSuccessValue()
    {
        $value = 'some key or password';

        $keyConfig = $this->factory->createKeyConfiguration(['value' => $value]);

        $this->assertInstanceOf(KeyConfiguration::class, $keyConfig);
        $this->assertSame($value, $keyConfig->getValue());
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

    /**
     * Create mock for KeyTypeRegistryInterface.
     *
     * @return KeyTypeRegistryInterface|MockObject
     */
    private function createKeyTypeRegistryInterfaceMock()
    {
        return $this->getMockBuilder(KeyTypeRegistryInterface::class)->getMock();
    }
}
