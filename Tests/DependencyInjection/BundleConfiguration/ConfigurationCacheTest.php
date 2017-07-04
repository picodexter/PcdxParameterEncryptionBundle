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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ConfigurationCache;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterInterface;

class ConfigurationCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigurationCache
     */
    private $cache;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->cache = new ConfigurationCache();
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
        $rewriterOne = $this->createRewriterInterfaceMock();
        $rewriterTwo = $this->createRewriterInterfaceMock();
        $prepConfig = [
            'some' => 'config',
        ];

        $this->assertNull($this->cache->get($rewriterOne));
        $this->assertNull($this->cache->get($rewriterTwo));

        $this->cache->set($rewriterOne, $prepConfig);

        $this->assertSame($prepConfig, $this->cache->get($rewriterOne));
        $this->assertNull($this->cache->get($rewriterTwo));
    }

    public function testHasSuccess()
    {
        $rewriterOne = $this->createRewriterInterfaceMock();
        $rewriterTwo = $this->createRewriterInterfaceMock();

        $this->assertFalse($this->cache->has($rewriterOne));
        $this->assertFalse($this->cache->has($rewriterTwo));

        $this->cache->set($rewriterOne, ['some' => 'config']);

        $this->assertTrue($this->cache->has($rewriterOne));
        $this->assertFalse($this->cache->has($rewriterTwo));
    }

    /**
     * Create mock for RewriterInterface.
     *
     * @return RewriterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createRewriterInterfaceMock()
    {
        return $this->getMockBuilder(RewriterInterface::class)->getMock();
    }
}
