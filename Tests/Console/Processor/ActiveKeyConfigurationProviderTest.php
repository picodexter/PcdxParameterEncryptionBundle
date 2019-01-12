<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Processor;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfigurationFactoryInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\ActiveKeyConfigurationProvider;

class ActiveKeyConfigurationProviderTest extends TestCase
{
    /**
     * @var KeyConfigurationFactoryInterface|MockObject
     */
    private $keyConfigFactory;

    /**
     * @var ActiveKeyConfigurationProvider
     */
    private $provider;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->keyConfigFactory = $this->createKeyConfigurationFactoryInterfaceMock();

        $this->provider = new ActiveKeyConfigurationProvider($this->keyConfigFactory);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->provider = null;
        $this->keyConfigFactory = null;
    }

    public function testGetActiveKeyConfigurationSuccessUseAlgorithmKey()
    {
        $isKeyProvided = false;
        $requestKey = 'key from the request';
        $algorithmKeyConfig = $this->createKeyConfigurationMock();

        $this->keyConfigFactory->expects($this->never())
            ->method('createKeyConfiguration');

        $keyConfig = $this->provider->getActiveKeyConfiguration($isKeyProvided, $requestKey, $algorithmKeyConfig);

        $this->assertSame($algorithmKeyConfig, $keyConfig);
    }

    public function testGetActiveKeyConfigurationSuccessUseRequestKey()
    {
        $isKeyProvided = true;
        $requestKey = 'key from the request';
        $algorithmKeyConfig = $this->createKeyConfigurationMock();

        $prepKeyConfig = $this->createKeyConfigurationMock();

        $this->keyConfigFactory->expects($this->once())
            ->method('createKeyConfiguration')
            ->will($this->returnValue($prepKeyConfig));

        $keyConfig = $this->provider->getActiveKeyConfiguration($isKeyProvided, $requestKey, $algorithmKeyConfig);

        $this->assertSame($prepKeyConfig, $keyConfig);
    }

    /**
     * Create mock for KeyConfigurationFactoryInterface.
     *
     * @return KeyConfigurationFactoryInterface|MockObject
     */
    private function createKeyConfigurationFactoryInterfaceMock()
    {
        return $this->getMockBuilder(KeyConfigurationFactoryInterface::class)->getMock();
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
}
