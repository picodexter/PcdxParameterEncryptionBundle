<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\ParameterReplacementPass;
use Picodexter\ParameterEncryptionBundle\PcdxParameterEncryptionBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PcdxParameterEncryptionBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildSuccess()
    {
        $bundle = new PcdxParameterEncryptionBundle();

        $container = $this->createContainerBuilderMock();

        $container->expects($this->once())
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(ParameterReplacementPass::class));

        $bundle->build($container);
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)->getMock();
    }
}
