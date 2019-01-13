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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ConfigurationFetcherInterface.
 */
interface ConfigurationFetcherInterface
{
    /**
     * Get processed extension configuration for rewriter.
     *
     * @param RewriterInterface $rewriter
     * @param ContainerBuilder  $container
     *
     * @return array
     */
    public function getProcessedConfig(RewriterInterface $rewriter, ContainerBuilder $container);
}
