<?php

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

/**
 * ConfigurationCacheInterface.
 */
interface ConfigurationCacheInterface
{
    /**
     * Get cache entry for rewriter.
     *
     * @param RewriterInterface $rewriter
     *
     * @return array|null
     */
    public function get(RewriterInterface $rewriter);

    /**
     * Check if cache entry exists for rewriter.
     *
     * @param RewriterInterface $rewriter
     *
     * @return bool
     */
    public function has(RewriterInterface $rewriter);

    /**
     * Set cache entry for rewriter.
     *
     * @param RewriterInterface $rewriter
     * @param array             $config
     */
    public function set(RewriterInterface $rewriter, array $config);
}
