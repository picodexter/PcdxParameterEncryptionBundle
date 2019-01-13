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

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\AbstractRewriter;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class AbstractRewriterTest extends TestCase
{
    /**
     * @var AbstractRewriter|DummyAbstractRewriter
     */
    private $rewriter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->rewriter = new DummyAbstractRewriter();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->rewriter = null;
    }

    public function testGetSetConfigurationSuccess()
    {
        $this->assertNull($this->rewriter->getConfiguration());

        $configuration = $this->createConfigurationInterfaceMock();

        $this->rewriter->setConfiguration($configuration);

        $this->assertSame($configuration, $this->rewriter->getConfiguration());
    }

    public function testGetSetExtensionConfigurationKeySuccess()
    {
        $this->assertSame('', $this->rewriter->getExtensionConfigurationKey());

        $extensionConfigKey = 'some_extension';

        $this->rewriter->setExtensionConfigurationKey($extensionConfigKey);

        $this->assertSame($extensionConfigKey, $this->rewriter->getExtensionConfigurationKey());
    }

    /**
     * Create mock for ConfigurationInterface.
     *
     * @return ConfigurationInterface|MockObject
     */
    private function createConfigurationInterfaceMock()
    {
        return $this->getMockBuilder(ConfigurationInterface::class)->getMock();
    }
}
