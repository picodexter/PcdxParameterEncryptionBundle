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
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\EnvironmentPlaceholderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;

class EnvironmentPlaceholderResolverTest extends TestCase
{
    /**
     * @var EnvironmentPlaceholderResolver
     */
    private $resolver;

    /**
     * PHPUnit: setUp.
     */
    protected function setUp()
    {
        if (!class_exists(EnvPlaceholderParameterBag::class)) {
            $this->markTestSkipped('Symfony 3.2+ is required for this test.');
        }

        $this->resolver = new EnvironmentPlaceholderResolver();
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

        $prepResolvedValue = 'some resolved value';

        $prepContainer = $this->createContainerBuilderMock();

        $prepContainer->expects($this->once())
            ->method('resolveEnvPlaceholders')
            ->with(
                $this->identicalTo($parameterValue),
                $this->identicalTo(true)
            )
            ->will($this->returnValue($prepResolvedValue));

        $resolvedValue = $this->resolver->resolveEnvironmentPlaceholders($parameterValue, $prepContainer);

        $this->assertSame($prepResolvedValue, $resolvedValue);
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['resolveEnvPlaceholders'])
            ->getMock();
    }
}
