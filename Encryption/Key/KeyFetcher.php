<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Key;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;

/**
 * KeyFetcher.
 */
class KeyFetcher implements KeyFetcherInterface
{
    /**
     * @var KeyCacheInterface
     */
    private $keyCache;

    /**
     * @var KeyResolverInterface
     */
    private $keyResolver;

    /**
     * Constructor.
     *
     * @param KeyCacheInterface    $keyCache
     * @param KeyResolverInterface $keyResolver
     */
    public function __construct(KeyCacheInterface $keyCache, KeyResolverInterface $keyResolver)
    {
        $this->keyCache = $keyCache;
        $this->keyResolver = $keyResolver;
    }

    /**
     * @inheritDoc
     */
    public function getKeyForConfig(KeyConfiguration $keyConfig)
    {
        if (!$this->keyCache->has($keyConfig)) {
            $key = $this->keyResolver->resolveKey($keyConfig);

            $this->keyCache->set($keyConfig, $key);
        } else {
            $key = $this->keyCache->get($keyConfig);
        }

        return $key;
    }
}
