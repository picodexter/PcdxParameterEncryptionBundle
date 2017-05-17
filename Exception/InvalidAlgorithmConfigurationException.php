<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Exception;

use Throwable;

/**
 * InvalidAlgorithmConfigurationException.
 */
class InvalidAlgorithmConfigurationException extends ConfigurationException
{
    /**
     * @inheritDoc
     */
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Invalid algorithm configuration', 0, $previous);
    }
}
