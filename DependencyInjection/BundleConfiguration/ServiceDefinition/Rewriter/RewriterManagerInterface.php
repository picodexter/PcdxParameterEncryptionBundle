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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * RewriterManagerInterface.
 */
interface RewriterManagerInterface
{
    /**
     * Process service definition.
     *
     * @param string           $serviceId
     * @param Definition       $definition
     * @param ContainerBuilder $container
     */
    public function processServiceDefinition($serviceId, Definition $definition, ContainerBuilder $container);
}
