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

namespace Picodexter\ParameterEncryptionBundle\Tests\Replacement\Pattern\Registry;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\Registry\ReplacementPatternRegistry;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

class ReplacementPatternRegistryTest extends TestCase
{
    /**
     * @param array $replacementPatterns
     * @param int   $expectedCount
     *
     * @dataProvider provideReplacementPatternData
     */
    public function testConstructorSuccess(array $replacementPatterns, $expectedCount)
    {
        $patternRegistry = new ReplacementPatternRegistry($replacementPatterns);

        $this->assertCount($expectedCount, $patternRegistry->getReplacementPatterns());
    }

    /**
     * Data provider.
     */
    public function provideReplacementPatternData()
    {
        return [
            'empty - empty input' => [
                [],
                0,
            ],
            'empty - not patterns' => [
                [
                    'algo_01' => true,
                    'algo_02' => false,
                    'algo_03' => 1,
                    'algo_04' => 1.1,
                    'algo_05' => 'string',
                ],
                0,
            ],
            '1 pattern' => [
                [
                    'algo_01' => $this->createReplacementPatternInterfaceMock(),
                ],
                1,
            ],
            'mixed - 2 patterns and random data' => [
                [
                    'algo_01' => 1,
                    'algo_02' => $this->createReplacementPatternInterfaceMock(),
                    'algo_03' => $this->createReplacementPatternInterfaceMock(),
                    'algo_04' => 1.1,
                    'algo_05' => 'string',
                ],
                2,
            ],
        ];
    }

    /**
     * @param array $replacementPatterns
     * @param int   $expectedCount
     *
     * @dataProvider provideReplacementPatternData
     */
    public function testSetReplacementPatternsSuccess(array $replacementPatterns, $expectedCount)
    {
        $patternRegistry = new ReplacementPatternRegistry([]);

        $patternRegistry->setReplacementPatterns($replacementPatterns);

        $this->assertCount($expectedCount, $patternRegistry->getReplacementPatterns());
    }

    public function testGetSuccessFound()
    {
        $findKey = 'algo_01';
        $findValue = $this->createReplacementPatternInterfaceMock();

        $patternRegistry = new ReplacementPatternRegistry([
            $findKey  => $findValue,
            'algo_02' => $this->createReplacementPatternInterfaceMock(),
        ]);

        $result = $patternRegistry->get($findKey);

        $this->assertSame($findValue, $result);
    }

    public function testGetSuccessNotFound()
    {
        $patternRegistry = new ReplacementPatternRegistry([
            'algo_01' => $this->createReplacementPatternInterfaceMock(),
        ]);

        $result = $patternRegistry->get('algo_nofind');

        $this->assertNull($result);
    }

    public function testHasSuccessFound()
    {
        $patternRegistry = new ReplacementPatternRegistry([
            'algo_01' => $this->createReplacementPatternInterfaceMock(),
        ]);

        $result = $patternRegistry->has('algo_01');

        $this->assertTrue($result);
    }

    public function testHasSuccessNotFound()
    {
        $patternRegistry = new ReplacementPatternRegistry([
            'algo_01' => $this->createReplacementPatternInterfaceMock(),
        ]);

        $result = $patternRegistry->has('algo_nofind');

        $this->assertFalse($result);
    }

    /**
     * Create mock for ReplacementPatternInterface.
     *
     * @return ReplacementPatternInterface|MockObject
     */
    private function createReplacementPatternInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInterface::class)->getMock();
    }
}
