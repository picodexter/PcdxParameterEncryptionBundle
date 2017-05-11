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

use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Source\DecrypterReplacementSource;

class DecrypterReplacementSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $decrypter;

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
        $this->replacementPattern = $this->createReplacementPatternInterfaceMock();
        $this->source = new DecrypterReplacementSource($this->decrypter, $this->replacementPattern);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->source = null;
        $this->replacementPattern = null;
        $this->decrypter = null;
    }

    /**
     * @param string|null $preparedDecryptedValue
     *
     * @dataProvider provideGetReplacedValueForParameterSuccessData
     */
    public function testGetReplacedValueForParameterSuccess($preparedDecryptedValue)
    {
        $parameterKey = 'some_key';
        $parameterValue = 'some value';
        $replaceableValue = 'encrypted text';

        $this->replacementPattern->expects($this->once())
            ->method('getValueWithoutPatternForParameter')
            ->with(
                $this->identicalTo($parameterKey),
                $this->identicalTo($parameterValue)
            )
            ->will($this->returnValue($replaceableValue));

        $this->decrypter->expects($this->once())
            ->method('decryptValue')
            ->with($this->identicalTo($replaceableValue))
            ->will($this->returnValue($preparedDecryptedValue));

        $decryptedValue = $this->source->getReplacedValueForParameter($parameterKey, $parameterValue);

        $this->assertSame($preparedDecryptedValue, $decryptedValue);
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
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createDecrypterInterfaceMock()
    {
        return $this->getMockBuilder(DecrypterInterface::class)->getMock();
    }

    /**
     * Create mock for ReplacementPatternInterface.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createReplacementPatternInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInterface::class)->getMock();
    }
}
