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

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration\ServiceDefinition;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\ArgumentReplacer;

class ArgumentReplacerTest extends TestCase
{
    /**
     * @param array  $arguments
     * @param array  $replacements
     * @param string $argumentKey
     * @param array  $expectedArguments
     *
     * @dataProvider provideReplaceArgumentsData
     */
    public function testReplaceArgumentIfExistsSuccess(
        array $arguments,
        array $replacements,
        $argumentKey,
        array $expectedArguments
    ) {
        $replacer = new ArgumentReplacer();

        $replacedArguments = $replacer->replaceArgumentIfExists($arguments, $replacements, $argumentKey);

        $this->assertSame($expectedArguments, $replacedArguments);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideReplaceArgumentsData()
    {
        return [
            'successful replacement' => [
                [
                    'some' => 'arguments',
                    'in'   => 'here',
                ],
                [
                    'some'  => 'new arguments',
                    'other' => 'data',
                ],
                'some',
                [
                    'some' => 'new arguments',
                    'in'   => 'here',
                ],
            ],
            'nonexistent key in arguments' => [
                [
                    'some' => 'arguments',
                    'in'   => 'here',
                ],
                [
                    'replace' => 'me',
                ],
                'replace',
                [
                    'some' => 'arguments',
                    'in'   => 'here',
                ],
            ],
            'nonexistent key in replacements' => [
                [
                    'some' => 'arguments',
                    'in'   => 'here',
                ],
                [
                    'something' => 'irrelevant',
                ],
                'some',
                [
                    'some' => 'arguments',
                    'in'   => 'here',
                ],
            ],
        ];
    }
}
