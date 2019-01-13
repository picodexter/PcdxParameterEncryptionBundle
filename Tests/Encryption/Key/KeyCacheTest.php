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

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyCache;

class KeyCacheTest extends TestCase
{
    /**
     * @var KeyCache
     */
    private $cache;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->cache = new KeyCache();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->cache = null;
    }

    public function testGetSetSuccess()
    {
        $preparedKey = 'some key';

        $keyConfig = $this->createKeyConfiguration('value 1');
        $unknownKeyConfig = $this->createKeyConfiguration('value 2');

        $this->assertNull($this->cache->get($keyConfig));
        $this->assertNull($this->cache->get($unknownKeyConfig));

        $this->cache->set($keyConfig, $preparedKey);

        $this->assertSame($preparedKey, $this->cache->get($keyConfig));
        $this->assertNull($this->cache->get($unknownKeyConfig));
    }

    public function testHasSuccess()
    {
        $preparedKey = 'some key';

        $keyConfig = $this->createKeyConfiguration('value 1');
        $unknownKeyConfig = $this->createKeyConfiguration('value 2');

        $this->assertFalse($this->cache->has($keyConfig));
        $this->assertFalse($this->cache->has($unknownKeyConfig));

        $this->cache->set($keyConfig, $preparedKey);

        $this->assertTrue($this->cache->has($keyConfig));
        $this->assertFalse($this->cache->has($unknownKeyConfig));
    }

    /**
     * Create a key configuration.
     *
     * @param string $value
     *
     * @return KeyConfiguration
     */
    private function createKeyConfiguration($value)
    {
        $keyConfig = new KeyConfiguration();

        $keyConfig->setValue($value);

        return $keyConfig;
    }
}
