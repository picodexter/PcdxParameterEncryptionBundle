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

namespace Picodexter\ParameterEncryptionBundle\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\BundleConfigurationServiceDefinitionRewriterServiceTagPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\KeyNotEmptyServiceTagPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\ParameterReplacementPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\UpdateBundleConfigurationServiceDefinitionsWithResolvedParametersPass;
use Picodexter\ParameterEncryptionBundle\PcdxParameterEncryptionBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PcdxParameterEncryptionBundleTest extends TestCase
{
    public function testBuildSuccess()
    {
        $bundle = new PcdxParameterEncryptionBundle();

        $container = $this->createContainerBuilderMock();

        $container->expects($this->exactly(4))
            ->method('addCompilerPass')
            ->withConsecutive(
                $this->isInstanceOf(BundleConfigurationServiceDefinitionRewriterServiceTagPass::class),
                $this->isInstanceOf(KeyNotEmptyServiceTagPass::class),
                $this->isInstanceOf(ParameterReplacementPass::class),
                $this->isInstanceOf(UpdateBundleConfigurationServiceDefinitionsWithResolvedParametersPass::class)
            );

        $bundle->build($container);
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['addCompilerPass'])
            ->getMock();
    }
}
