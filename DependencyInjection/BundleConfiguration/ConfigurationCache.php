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

/**
 * ConfigurationCache.
 */
class ConfigurationCache implements ConfigurationCacheInterface
{
    /**
     * @var array
     */
    private $configs = [];

    /**
     * @inheritDoc
     */
    public function get(RewriterInterface $rewriter)
    {
        return ($this->has($rewriter) ? $this->configs[$this->getIdentifierForRewriter($rewriter)] : null);
    }

    /**
     * @inheritDoc
     */
    public function has(RewriterInterface $rewriter)
    {
        return array_key_exists($this->getIdentifierForRewriter($rewriter), $this->configs);
    }

    /**
     * @inheritDoc
     */
    public function set(RewriterInterface $rewriter, array $config)
    {
        $this->configs[$this->getIdentifierForRewriter($rewriter)] = $config;
    }

    /**
     * Get identifier for rewriter.
     *
     * @param RewriterInterface $rewriter
     *
     * @return string
     */
    private function getIdentifierForRewriter(RewriterInterface $rewriter)
    {
        return spl_object_hash($rewriter);
    }
}
