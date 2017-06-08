<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration\Key;

use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidKeyTypeException;

/**
 * KeyConfigurationFactoryInterface.
 */
interface KeyConfigurationFactoryInterface
{
    /**
     * Create key configuration.
     *
     * @param array $keyConfig
     *
     * @throws InvalidKeyTypeException
     */
    public function createKeyConfiguration(array $keyConfig);
}
