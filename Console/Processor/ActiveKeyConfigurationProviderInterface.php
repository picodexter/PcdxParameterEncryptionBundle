<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Processor;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;

/**
 * ActiveKeyConfigurationProviderInterface.
 */
interface ActiveKeyConfigurationProviderInterface
{
    /**
     * Get active key configuration.
     *
     * @param bool             $isKeyProvided
     * @param string|null      $requestKey
     * @param KeyConfiguration $algorithmKeyConfig
     *
     * @return KeyConfiguration
     */
    public function getActiveKeyConfiguration($isKeyProvided, $requestKey, KeyConfiguration $algorithmKeyConfig);
}
