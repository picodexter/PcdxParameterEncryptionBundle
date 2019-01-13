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

namespace Picodexter\ParameterEncryptionBundle;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\BundleConfigurationServiceDefinitionRewriterServiceTagPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\KeyNotEmptyServiceTagPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\ParameterReplacementPass;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler\UpdateBundleConfigurationServiceDefinitionsWithResolvedParametersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * PcdxParameterEncryptionBundle.
 */
class PcdxParameterEncryptionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new BundleConfigurationServiceDefinitionRewriterServiceTagPass());
        $container->addCompilerPass(new KeyNotEmptyServiceTagPass());
        $container->addCompilerPass(new ParameterReplacementPass());
        $container->addCompilerPass(new UpdateBundleConfigurationServiceDefinitionsWithResolvedParametersPass());
    }
}
