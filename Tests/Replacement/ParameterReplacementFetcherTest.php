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

namespace Picodexter\ParameterEncryptionBundle\Tests\Replacement;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Replacement\ParameterReplacementFetcher;
use Picodexter\ParameterEncryptionBundle\Replacement\Source\ReplacementSourceInterface;
use ReflectionProperty;
use stdClass;

class ParameterReplacementFetcherTest extends TestCase
{
    /**
     * @param array $replacementSources
     * @param array $expectedResults
     *
     * @dataProvider provideSetReplacementSourcesSuccessData
     */
    public function testSetReplacementSourcesSuccessEmptyNoInputData(array $replacementSources, $expectedResults)
    {
        $parameterReplacer = new ParameterReplacementFetcher($replacementSources);

        $this->assertSame($expectedResults, $this->getReplacementSourcesFromParameterReplacer($parameterReplacer));
    }

    /**
     * Data provider.
     */
    public function provideSetReplacementSourcesSuccessData()
    {
        $data = [
            'empty - no input data' => [
                [],
                [],
            ],
            'empty - invalid input data' => [
                [
                    false,
                    2,
                    'string 123',
                    3,
                    new stdClass(),
                ],
                [],
            ],
        ];

        $sources = [];
        $sources[] = $this->createReplacementSourceInterfaceMock();

        $data['one valid element - valid input only'] = [
            $sources,
            $sources,
        ];

        $sources[] = $this->createReplacementSourceInterfaceMock();
        $sources[] = $this->createReplacementSourceInterfaceMock();

        $data['three valid elements - valid input only'] = [
            $sources,
            $sources,
        ];

        $mixedSources = $sources;
        $mixedSources[] = 3;
        $mixedSources[] = true;

        $data['three valid elements - valid and invalid input'] = [
            $mixedSources,
            $sources,
        ];

        return $data;
    }

    public function testGetReplacedValueForParameterSuccessOneSourceNotReplaced()
    {
        $parameterKey = 'some_key';
        $parameterValue = 'some value';

        $source = $this->createReplacementSourceInterfaceMock();
        $replacementFetcher = new ParameterReplacementFetcher([$source]);

        $source->expects($this->once())
            ->method('isApplicableForParameter')
            ->with(
                $this->identicalTo($parameterKey),
                $this->identicalTo($parameterValue)
            )
            ->will($this->returnValue(false));

        $value = $replacementFetcher->getReplacedValueForParameter($parameterKey, $parameterValue);

        $this->assertNull($value);
    }

    public function testGetReplacedValueForParameterSuccessOneSourceReplacedOnce()
    {
        $parameterKey = 'some_key';
        $parameterValue = 'some value';
        $preparedReplacedValue = 'replaced value';

        $source = $this->createReplacementSourceInterfaceMock();
        $replacementFetcher = new ParameterReplacementFetcher([$source]);

        $this->prepareReplacementSourceInterfaceMockForReplacement(
            $source,
            $parameterKey,
            $parameterValue,
            $preparedReplacedValue
        );

        $value = $replacementFetcher->getReplacedValueForParameter($parameterKey, $parameterValue);

        $this->assertSame($preparedReplacedValue, $value);
    }

    public function testGetReplacedValueForParameterSuccessThreeSourcesReplacedThreeTimes()
    {
        $parameterKey = 'some_key';
        $parameterValue = 'some value';
        $lastReplacedValue = 'final replaced value';

        $source1 = $this->createReplacementSourceInterfaceMock();
        $source2 = $this->createReplacementSourceInterfaceMock();
        $source3 = $this->createReplacementSourceInterfaceMock();

        $replacementFetcher = new ParameterReplacementFetcher([
            $source1,
            $source2,
            $source3,
        ]);

        $this->prepareReplacementSourceInterfaceMockForReplacement(
            $source1,
            $parameterKey,
            $parameterValue,
            'value 1'
        );
        $this->prepareReplacementSourceInterfaceMockForReplacement(
            $source2,
            $parameterKey,
            'value 1',
            'value 2'
        );
        $this->prepareReplacementSourceInterfaceMockForReplacement(
            $source3,
            $parameterKey,
            'value 2',
            $lastReplacedValue
        );

        $value = $replacementFetcher->getReplacedValueForParameter($parameterKey, $parameterValue);

        $this->assertSame($lastReplacedValue, $value);
    }

    /**
     * @param mixed $parameterValue
     *
     * @dataProvider provideGetReplacedValueForParameterSuccessValueNotStringData
     */
    public function testGetReplacedValueForParameterSuccessValueNotString($parameterValue)
    {
        $parameterKey = 'some_key';

        $source = $this->createReplacementSourceInterfaceMock();
        $replacementFetcher = new ParameterReplacementFetcher([$source]);

        $value = $replacementFetcher->getReplacedValueForParameter($parameterKey, $parameterValue);

        $this->assertNull($value);
    }

    /**
     * Data provider.
     */
    public function provideGetReplacedValueForParameterSuccessValueNotStringData()
    {
        return [
            'value = null' => [
                null,
            ],
            'value = boolean' => [
                false,
            ],
            'value = integer' => [
                123,
            ],
            'value = float' => [
                123.123,
            ],
            'value = stdClass object' => [
                new stdClass(),
            ],
        ];
    }

    /**
     * Create mock for ReplacementSourceInterface.
     *
     * @return ReplacementSourceInterface|MockObject
     */
    private function createReplacementSourceInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementSourceInterface::class)->getMock();
    }

    /**
     * Get ReplacementSources from ParameterReplacementFetcher.
     *
     * @param ParameterReplacementFetcher $fetchStrategy
     *
     * @return array
     */
    private function getReplacementSourcesFromParameterReplacer(ParameterReplacementFetcher $fetchStrategy)
    {
        $reflectionProperty = new ReflectionProperty(ParameterReplacementFetcher::class, 'replacementSources');
        $reflectionProperty->setAccessible(true);
        $replacementSources = $reflectionProperty->getValue($fetchStrategy);

        return $replacementSources;
    }

    /**
     * Prepare replacement source for replacement.
     *
     * @param ReplacementSourceInterface|MockObject $source
     * @param string                                $parameterKey
     * @param string                                $parameterValue
     * @param string|null                           $replacedValue
     */
    private function prepareReplacementSourceInterfaceMockForReplacement(
        ReplacementSourceInterface $source,
        $parameterKey,
        $parameterValue,
        $replacedValue
    ) {
        $source->expects($this->once())
            ->method('isApplicableForParameter')
            ->with(
                $this->identicalTo($parameterKey),
                $this->identicalTo($parameterValue)
            )
            ->will($this->returnValue(true));

        $source->expects($this->once())
            ->method('getReplacedValueForParameter')
            ->with(
                $this->identicalTo($parameterKey),
                $this->identicalTo($parameterValue)
            )
            ->will($this->returnValue($replacedValue));
    }
}
