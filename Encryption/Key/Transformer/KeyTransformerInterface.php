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

namespace Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidKeyConfigurationException;

/**
 * KeyTransformerInterface.
 */
interface KeyTransformerInterface
{
    /**
     * Check if this transformer applies to the given key and key configuration.
     *
     * @param string           $key
     * @param KeyConfiguration $keyConfig
     *
     * @return bool
     */
    public function appliesFor($key, KeyConfiguration $keyConfig);

    /**
     * Transform key.
     *
     * @param string           $key
     * @param KeyConfiguration $keyConfig
     *
     * @throws InvalidKeyConfigurationException
     *
     * @return string
     */
    public function transform($key, KeyConfiguration $keyConfig);
}
