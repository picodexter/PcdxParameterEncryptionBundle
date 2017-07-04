<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * BundleConfigurationServiceDefinitionRewriterServiceTagPass.
 */
class BundleConfigurationServiceDefinitionRewriterServiceTagPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $processor = $container
            ->get(ServiceNames::SERVICE_TAG_PROCESSOR_BUNDLE_CONFIGURATION_SERVICE_DEFINITION_REWRITER);

        $processor->process($container);
    }
}
