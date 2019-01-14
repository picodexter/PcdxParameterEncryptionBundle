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

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Parameter;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\LegacyEnvironmentPlaceholderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LegacyEnvironmentPlaceholderResolverTest extends TestCase
{
    /**
     * @var LegacyEnvironmentPlaceholderResolver
     */
    private $resolver;

    /**
     * PHPUnit: setUp.
     */
    protected function setUp()
    {
        $this->resolver = new LegacyEnvironmentPlaceholderResolver();
    }

    /**
     * PHPUnit: tearDown.
     */
    protected function tearDown()
    {
        $this->resolver = null;
    }

    public function testResolveEnvironmentPlaceholdersSuccess()
    {
        $parameterValue = 'some parameter value';

        $prepContainer = $this->createContainerBuilderMock();

        $resolvedValue = $this->resolver->resolveEnvironmentPlaceholders($parameterValue, $prepContainer);

        $this->assertSame($parameterValue, $resolvedValue);
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
}
