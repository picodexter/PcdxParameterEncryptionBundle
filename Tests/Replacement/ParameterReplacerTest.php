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
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\EnvironmentPlaceholderResolverInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\ParameterReplacementFetcherInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\ParameterReplacer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ParameterReplacerTest extends TestCase
{
    /**
     * @var EnvironmentPlaceholderResolverInterface|MockObject
     */
    private $environmentPlaceholderResolver;

    /**
     * @var ParameterReplacer
     */
    private $parameterReplacer;

    /**
     * @var ParameterReplacementFetcherInterface|MockObject
     */
    private $replacementFetcher;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->environmentPlaceholderResolver = $this->createEnvironmentPlaceholderResolverInterfaceMock();
        $this->replacementFetcher = $this->createParameterReplacementFetcherInterfaceMock();

        $this->parameterReplacer = new ParameterReplacer(
            $this->environmentPlaceholderResolver,
            $this->replacementFetcher
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->parameterReplacer = null;
        $this->replacementFetcher = null;
        $this->environmentPlaceholderResolver = null;
    }

    /**
     * @param array $inputParameters
     * @param array $expectedParameters
     *
     * @dataProvider provideProcessParametersSuccessData
     */
    public function testProcessParameterBagSuccess(array $inputParameters, array $expectedParameters)
    {
        $parameterBag = new ParameterBag($inputParameters);

        $prepContainer = $this->createContainerBuilderMock();

        $this->prepareReplacementFetcherInterfaceMockForConditionalReplacement($this->replacementFetcher);

        $processedBag = $this->parameterReplacer->processParameterBag($parameterBag, $prepContainer);

        $this->assertSame(
            $parameterBag,
            $processedBag,
            'Operations should have been executed on the input object.'
        );
        $this->assertSame($expectedParameters, $parameterBag->all());
    }

    /**
     * @param array $inputParameters
     * @param array $expectedParameters
     *
     * @dataProvider provideProcessParametersSuccessData
     */
    public function testProcessParametersSuccess(array $inputParameters, array $expectedParameters)
    {
        $prepContainer = $this->createContainerBuilderMock();

        $this->prepareReplacementFetcherInterfaceMockForConditionalReplacement($this->replacementFetcher);

        $processedParameters = $this->parameterReplacer->processParameters($inputParameters, $prepContainer);

        $this->assertSame($expectedParameters, $processedParameters);
    }

    /**
     * Data provider.
     */
    public function provideProcessParametersSuccessData()
    {
        return [
            'empty' => [
                [],
                [],
            ],
            'no replacement - no match' => [
                [
                    'some_key' => 'some value',
                ],
                [
                    'some_key' => 'some value',
                ],
            ],
            'replaced - flat' => [
                [
                    'replace_me' => 'some value',
                ],
                [
                    'replace_me' => 'replaced value',
                ],
            ],
            'replaced - nested' => [
                [
                    'some_key' => 'some value',
                    'branch_a' => [
                        'replace_me' => 'some value',
                    ],
                    'branch_b' => [
                        'replace_me'    => 'another value',
                        'different_key' => 'different value',
                        'branch_b_a'    => [
                            'replace_me' => 'another replacement',
                        ],
                        'branch_b_b'    => [
                            'replace_me' => 'abc',
                        ],
                    ],
                    'replace_me' => 'yet another value',
                ],
                [
                    'some_key' => 'some value',
                    'branch_a' => [
                        'replace_me' => 'replaced value',
                    ],
                    'branch_b' => [
                        'replace_me'    => 'replaced value',
                        'different_key' => 'different value',
                        'branch_b_a'    => [
                            'replace_me' => 'replaced value',
                        ],
                        'branch_b_b'    => [
                            'replace_me' => 'replaced value',
                        ],
                    ],
                    'replace_me' => 'replaced value',
                ],
            ],
        ];
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['get'])
            ->getMock();
    }

    /**
     * Create mock for EnvironmentPlaceholderResolverInterface.
     *
     * @return EnvironmentPlaceholderResolverInterface|MockObject
     */
    private function createEnvironmentPlaceholderResolverInterfaceMock()
    {
        return $this->getMockBuilder(EnvironmentPlaceholderResolverInterface::class)->getMock();
    }

    /**
     * Create mock for ParameterReplacementFetcherInterface.
     *
     * @return ParameterReplacementFetcherInterface|MockObject
     */
    private function createParameterReplacementFetcherInterfaceMock()
    {
        return $this->getMockBuilder(ParameterReplacementFetcherInterface::class)->getMock();
    }

    /**
     * Prepare replacement fetcher for conditional replacement.
     *
     * @param ParameterReplacementFetcherInterface|MockObject $replacementFetcher
     */
    private function prepareReplacementFetcherInterfaceMockForConditionalReplacement(
        ParameterReplacementFetcherInterface $replacementFetcher
    ) {
        $replacementFetcher->expects($this->any())
            ->method('getReplacedValueForParameter')
            ->will(
                $this->returnCallback(
                    function ($parameterKey) {
                        return ('replace_me' === $parameterKey ? 'replaced value' : null);
                    }
                )
            );
    }
}
