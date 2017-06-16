<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Replacement\Source;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyFetcherInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Source\DecrypterReplacementSource;

class DecrypterReplacementSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $decrypter;

    /**
     * @var KeyConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    private $keyConfig;

    /**
     * @var KeyFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $keyFetcher;

    /**
     * @var ReplacementPatternInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $replacementPattern;

    /**
     * @var DecrypterReplacementSource
     */
    private $source;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->decrypter = $this->createDecrypterInterfaceMock();
        $this->keyConfig = $this->createKeyConfigurationMock();
        $this->keyFetcher = $this->createKeyFetcherInterfaceMock();
        $this->replacementPattern = $this->createReplacementPatternInterfaceMock();

        $this->source = new DecrypterReplacementSource(
            $this->decrypter,
            $this->keyConfig,
            $this->keyFetcher,
            $this->replacementPattern
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->source = null;
        $this->replacementPattern = null;
        $this->keyFetcher = null;
        $this->keyConfig = null;
        $this->decrypter = null;
    }

    /**
     * @param string|null $prepDecryptedValue
     *
     * @dataProvider provideGetReplacedValueForParameterSuccessData
     */
    public function testGetReplacedValueForParameterSuccess($prepDecryptedValue)
    {
        $parameterKey = 'some_key';
        $parameterValue = 'some value';
        $decryptionKey = 'decryption key';
        $replaceableValue = 'encrypted text';

        $this->keyFetcher->expects($this->once())
            ->method('getKeyForConfig')
            ->with($this->keyConfig)
            ->will($this->returnValue($decryptionKey));

        $this->replacementPattern->expects($this->once())
            ->method('getValueWithoutPatternForParameter')
            ->with(
                $this->identicalTo($parameterKey),
                $this->identicalTo($parameterValue)
            )
            ->will($this->returnValue($replaceableValue));

        $this->decrypter->expects($this->once())
            ->method('decryptValue')
            ->with(
                $this->identicalTo($replaceableValue),
                $this->identicalTo($decryptionKey)
            )
            ->will($this->returnValue($prepDecryptedValue));

        $decryptedValue = $this->source->getReplacedValueForParameter($parameterKey, $parameterValue);

        $this->assertSame($prepDecryptedValue, $decryptedValue);
    }

    /**
     * Data provider.
     */
    public function provideGetReplacedValueForParameterSuccessData()
    {
        return [
            'result = string' => [
                'decrypted text',
            ],
            'result = null' => [
                null,
            ],
        ];
    }

    public function testIsApplicableForParameterSuccess()
    {
        $parameterKey = 'some_key';
        $parameterValue = 'example value';
        $preparedIsApplicable = true;

        $this->replacementPattern->expects($this->once())
            ->method('isApplicableForParameter')
            ->with(
                $this->identicalTo($parameterKey),
                $this->identicalTo($parameterValue)
            )
            ->will($this->returnValue($preparedIsApplicable));

        $isApplicable = $this->source->isApplicableForParameter($parameterKey, $parameterValue);

        $this->assertSame($preparedIsApplicable, $isApplicable);
    }

    /**
     * Create mock for DecrypterInterface.
     *
     * @return DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDecrypterInterfaceMock()
    {
        return $this->getMockBuilder(DecrypterInterface::class)->getMock();
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
     * Create mock for KeyFetcherInterface.
     *
     * @return KeyFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyFetcherInterfaceMock()
    {
        return $this->getMockBuilder(KeyFetcherInterface::class)->getMock();
    }

    /**
     * Create mock for ReplacementPatternInterface.
     *
     * @return ReplacementPatternInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReplacementPatternInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInterface::class)->getMock();
    }
}
