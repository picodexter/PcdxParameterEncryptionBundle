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

namespace Picodexter\ParameterEncryptionBundle\Console\Processor;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;

/**
 * TransformedKeyProviderInterface.
 */
interface TransformedKeyProviderInterface
{
    /**
     * Get transformed key.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @return TransformedKey
     */
    public function getTransformedKey(KeyConfiguration $keyConfig);
}
