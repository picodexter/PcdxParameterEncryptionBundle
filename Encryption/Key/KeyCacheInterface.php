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
 * KeyCacheInterface.
 */
interface KeyCacheInterface
{
    /**
     * Get key by configuration.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @return string|null
     */
    public function get(KeyConfiguration $keyConfig);

    /**
     * Check if key has been registered for the given configuration.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @return bool
     */
    public function has(KeyConfiguration $keyConfig);

    /**
     * Set key for configuration.
     *
     * @param KeyConfiguration $keyConfig
     * @param string|null      $key
     */
    public function set(KeyConfiguration $keyConfig, $key);
}
