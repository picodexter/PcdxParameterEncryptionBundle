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
 * KeyCache.
 */
class KeyCache implements KeyCacheInterface
{
    /**
     * @var array
     */
    private $keys = [];

    /**
     * @inheritDoc
     */
    public function get(KeyConfiguration $keyConfig)
    {
        $hash = $this->generateHashForKeyConfig($keyConfig);

        return (!$this->has($keyConfig) ? null : $this->keys[$hash]);
    }

    /**
     * @inheritDoc
     */
    public function has(KeyConfiguration $keyConfig)
    {
        $hash = $this->generateHashForKeyConfig($keyConfig);

        return array_key_exists($hash, $this->keys);
    }

    /**
     * @inheritDoc
     */
    public function set(KeyConfiguration $keyConfig, $key)
    {
        $hash = $this->generateHashForKeyConfig($keyConfig);

        $this->keys[$hash] = $key;
    }

    /**
     * Generate hash for key configuration.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @return string
     */
    private function generateHashForKeyConfig(KeyConfiguration $keyConfig)
    {
        $content = serialize($keyConfig);

        return hash('sha512', $content);
    }
}
