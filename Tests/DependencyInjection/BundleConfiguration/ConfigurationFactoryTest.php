<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ConfigurationFactory;
use Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection\InvalidConfigurationClassException;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationFactoryTest extends TestCase
{
    /**
     * @var ConfigurationFactory
     */
    private $factory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->factory = new ConfigurationFactory();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->factory = null;
    }

    public function testCreateConfigurationExceptionUnknownClass()
    {
        $this->expectException(InvalidConfigurationClassException::class);

        $this->factory->createConfiguration('\\Invalid\\Class');
    }

    public function testCreateConfigurationExceptionInvalidClass()
    {
        $this->expectException(InvalidConfigurationClassException::class);

        $this->factory->createConfiguration('\\ReflectionClass');
    }

    public function testCreateConfigurationSuccessWithArguments()
    {
        $argumentOne = 'hello';
        $argumentTwo = 'world';

        $configuration = $this->factory
            ->createConfiguration(DummyConfiguration::class, [$argumentOne, $argumentTwo]);

        $this->assertInstanceOf(ConfigurationInterface::class, $configuration);
        $this->assertSame($argumentOne, $configuration->argumentOne);
        $this->assertSame($argumentTwo, $configuration->argumentTwo);
    }

    public function testCreateConfigurationSuccessWithoutArguments()
    {
        $configuration = $this->factory->createConfiguration(DummyConfiguration::class);

        $this->assertInstanceOf(ConfigurationInterface::class, $configuration);
        $this->assertNull($configuration->argumentOne);
        $this->assertNull($configuration->argumentTwo);
    }
}
