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

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfiguration;
use Throwable;

/**
 * DuplicateAlgorithmIdException.
 */
class DuplicateAlgorithmIdException extends ConfigurationException
{
    /**
     * Constructor.
     *
     * @param AlgorithmConfiguration $algorithmConfig
     * @param Throwable|null         $previous
     */
    public function __construct(AlgorithmConfiguration $algorithmConfig, Throwable $previous = null)
    {
        parent::__construct('Duplicate algorithm ID "' . $algorithmConfig->getId() . '"', 0, $previous);
    }
}
