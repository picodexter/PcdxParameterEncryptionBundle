<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Exception\Configuration;

use Throwable;

/**
 * InvalidKeyConfigurationException.
 */
class InvalidKeyConfigurationException extends InvalidAlgorithmConfigurationException
{
    /**
     * @inheritDoc
     */
    public function __construct(Throwable $previous = null)
    {
        parent::__construct($previous);

        $this->message = 'Invalid key configuration';
    }
}
