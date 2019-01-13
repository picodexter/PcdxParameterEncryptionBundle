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

namespace Picodexter\ParameterEncryptionBundle\Tests\Replacement\Pattern;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\EmptyPrefixException;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ValuePrefixReplacementPattern;

class ValuePrefixReplacementPatternTest extends TestCase
{
    public function testConstructorExceptionMissingPrefix()
    {
        $this->expectException(EmptyPrefixException::class);

        new ValuePrefixReplacementPattern('');
    }

    /**
     * @param string      $prefix
     * @param string      $parameterKey
     * @param string      $parameterValue
     * @param string|null $expectedValue
     *
     * @dataProvider provideGetValueWithoutPatternForParameterSuccessData
     */
    public function testGetValueWithoutPatternForParameterSuccess(
        $prefix,
        $parameterKey,
        $parameterValue,
        $expectedValue
    ) {
        $pattern = new ValuePrefixReplacementPattern($prefix);

        $value = $pattern->getValueWithoutPatternForParameter($parameterKey, $parameterValue);

        $this->assertSame($expectedValue, $value);
    }

    /**
     * Data provider.
     */
    public function provideGetValueWithoutPatternForParameterSuccessData()
    {
        return [
            'match with UTF-8 character' => [
                'PREFIX✓',
                'some_key',
                'PREFIX✓partial parameter value',
                'partial parameter value',
            ],
            'not a match' => [
                'PREFIX1',
                'some_key',
                'partial parameter value',
                null,
            ],
        ];
    }

    /**
     * @param string $prefix
     * @param string $parameterKey
     * @param string $parameterValue
     * @param bool   $expectedResult
     *
     * @dataProvider provideIsApplicableForParameterSuccessData
     */
    public function testIsApplicableForParameterSuccess($prefix, $parameterKey, $parameterValue, $expectedResult)
    {
        $pattern = new ValuePrefixReplacementPattern($prefix);

        $isApplicable = $pattern->isApplicableForParameter($parameterKey, $parameterValue);

        $this->assertSame($expectedResult, $isApplicable);
    }

    /**
     * Data provider.
     */
    public function provideIsApplicableForParameterSuccessData()
    {
        return [
            'true - match' => [
                'PREFIX',
                'some_key',
                'PREFIXvalue',
                true,
            ],
            'false - wrong capitalization' => [
                'PREFIX',
                'some_key',
                'PREfiXvalue',
                false,
            ],
            'false - mismatch' => [
                'PREFIX',
                'some_key',
                'unprefixed value',
                false,
            ],
        ];
    }
}
