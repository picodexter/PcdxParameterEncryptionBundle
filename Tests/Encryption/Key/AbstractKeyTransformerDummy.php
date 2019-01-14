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

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Key;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer\KeyTransformerInterface;

/**
 * AbstractKeyTransformerDummy.
 */
class AbstractKeyTransformerDummy implements KeyTransformerInterface
{
    /**
     * @var bool
     */
    public $resultAppliesFor;

    /**
     * @var string
     */
    public $resultTransform;

    public function appliesFor($key, KeyConfiguration $keyConfig)
    {
        return $this->resultAppliesFor;
    }

    public function transform($key, KeyConfiguration $keyConfig)
    {
        return $key.'+'.$this->resultTransform;
    }
}
