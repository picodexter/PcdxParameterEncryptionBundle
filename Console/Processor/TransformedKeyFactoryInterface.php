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

/**
 * TransformedKeyFactoryInterface.
 */
interface TransformedKeyFactoryInterface
{
    /**
     * Create key container.
     *
     * @param string $originalKey
     * @param string $finalKey
     *
     * @return TransformedKey
     */
    public function createTransformedKey($originalKey, $finalKey);
}
