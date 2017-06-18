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
use Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer\KeyTransformerInterface;

/**
 * KeyResolverInterface.
 */
interface KeyResolverInterface
{
    /**
     * Setter: transformers.
     *
     * @param KeyTransformerInterface[] $transformers
     */
    public function setTransformers(array $transformers);

    /**
     * Resolve key configuration to key.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @return string
     */
    public function resolveKey(KeyConfiguration $keyConfig);
}
