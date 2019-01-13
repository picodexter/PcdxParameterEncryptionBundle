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

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Processor;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKey;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKeyFactoryInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKeyProvider;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyFetcherInterface;

class TransformedKeyProviderTest extends TestCase
{
    /**
     * @var KeyFetcherInterface|MockObject
     */
    private $keyFetcher;

    /**
     * @var TransformedKeyProvider
     */
    private $provider;

    /**
     * @var TransformedKeyFactoryInterface|MockObject
     */
    private $transformedKeyFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->keyFetcher = $this->createKeyFetcherInterfaceMock();
        $this->transformedKeyFactory = $this->createTransformedKeyFactoryInterfaceMock();

        $this->provider = new TransformedKeyProvider($this->keyFetcher, $this->transformedKeyFactory);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->provider = null;
        $this->transformedKeyFactory = null;
        $this->keyFetcher = null;
    }

    public function testGetTransformedKeySuccess()
    {
        $originalKey = 'some original key';
        $finalKey = 'some final key';

        $keyConfig = $this->createKeyConfigurationMock();
        $prepTransformedKey = $this->createTransformedKeyMock();

        $keyConfig->expects($this->once())
            ->method('getValue')
            ->with()
            ->will($this->returnValue($originalKey));

        $this->keyFetcher->expects($this->once())
            ->method('getKeyForConfig')
            ->with($this->identicalTo($keyConfig))
            ->will($this->returnValue($finalKey));

        $this->transformedKeyFactory->expects($this->once())
            ->method('createTransformedKey')
            ->with(
                $this->identicalTo($originalKey),
                $this->identicalTo($finalKey)
            )
            ->will($this->returnValue($prepTransformedKey));

        $transformedKey = $this->provider->getTransformedKey($keyConfig);

        $this->assertSame($prepTransformedKey, $transformedKey);
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
     * Create mock for KeyFetcherInterface.
     *
     * @return KeyFetcherInterface|MockObject
     */
    private function createKeyFetcherInterfaceMock()
    {
        return $this->getMockBuilder(KeyFetcherInterface::class)->getMock();
    }

    /**
     * Create mock for TransformedKeyFactoryInterface.
     *
     * @return TransformedKeyFactoryInterface|MockObject
     */
    private function createTransformedKeyFactoryInterfaceMock()
    {
        return $this->getMockBuilder(TransformedKeyFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for TransformedKey.
     *
     * @return TransformedKey|MockObject
     */
    private function createTransformedKeyMock()
    {
        return $this->getMockBuilder(TransformedKey::class)->getMock();
    }
}
