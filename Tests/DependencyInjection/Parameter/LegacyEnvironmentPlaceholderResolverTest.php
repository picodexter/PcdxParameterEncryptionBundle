<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Parameter;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\LegacyEnvironmentPlaceholderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LegacyEnvironmentPlaceholderResolverTest extends \PHPUnit_Framework_TestCase
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
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['get'])
            ->getMock();
    }
}
