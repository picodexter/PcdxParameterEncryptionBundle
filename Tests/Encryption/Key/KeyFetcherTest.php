<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Key;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyCacheInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyFetcher;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyResolverInterface;

class KeyFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyFetcher
     */
    private $fetcher;

    /**
     * @var KeyCacheInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $keyCache;

    /**
     * @var KeyResolverInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $keyResolver;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->keyCache = $this->createKeyCacheInterfaceMock();
        $this->keyResolver = $this->createKeyResolverInterfaceMock();

        $this->fetcher = new KeyFetcher($this->keyCache, $this->keyResolver);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->fetcher = null;
        $this->keyResolver = null;
        $this->keyCache = null;
    }

    public function testGetKeyForConfigSuccessExists()
    {
        $prepKey = 'some key';

        $keyConfig = $this->createKeyConfigurationMock();

        $this->setUpKeyCacheHas($keyConfig, true);

        $this->keyCache->expects($this->once())
            ->method('get')
            ->with($this->identicalTo($keyConfig))
            ->will($this->returnValue($prepKey));

        $key = $this->fetcher->getKeyForConfig($keyConfig);

        $this->assertSame($prepKey, $key);
    }

    public function testGetKeyForConfigSuccessNoExist()
    {
        $prepKey = 'some key';

        $keyConfig = $this->createKeyConfigurationMock();

        $this->setUpKeyCacheHas($keyConfig, false);

        $this->keyResolver->expects($this->once())
            ->method('resolveKey')
            ->with($this->identicalTo($keyConfig))
            ->will($this->returnValue($prepKey));

        $this->keyCache->expects($this->once())
            ->method('set')
            ->with(
                $this->identicalTo($keyConfig),
                $this->identicalTo($prepKey)
            );

        $key = $this->fetcher->getKeyForConfig($keyConfig);

        $this->assertSame($prepKey, $key);
    }

    /**
     * Create mock for KeyCacheInterface.
     *
     * @return KeyCacheInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyCacheInterfaceMock()
    {
        return $this->getMockBuilder(KeyCacheInterface::class)->getMock();
    }

    /**
     * Create mock for KeyConfiguration.
     *
     * @return KeyConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyConfigurationMock()
    {
        return $this->getMockBuilder(KeyConfiguration::class)->getMock();
    }

    /**
     * Create mock for KeyResolverInterface.
     *
     * @return KeyResolverInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyResolverInterfaceMock()
    {
        return $this->getMockBuilder(KeyResolverInterface::class)->getMock();
    }

    /**
     * Set up KeyCache: has.
     *
     * @param KeyConfiguration $keyConfig
     * @param bool             $result
     */
    private function setUpKeyCacheHas(KeyConfiguration $keyConfig, $result)
    {
        $this->keyCache->expects($this->once())
            ->method('has')
            ->with($this->identicalTo($keyConfig))
            ->will($this->returnValue($result));
    }
}
