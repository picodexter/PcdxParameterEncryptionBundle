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

use Picodexter\ParameterEncryptionBundle\Configuration\Algorithm;
use Throwable;

/**
 * DuplicateAlgorithmIdException.
 */
class DuplicateAlgorithmIdException extends ConfigurationException
{
    /**
     * Constructor.
     *
     * @param Algorithm      $algorithm
     * @param Throwable|null $previous
     */
    public function __construct(Algorithm $algorithm, Throwable $previous = null)
    {
        parent::__construct('Duplicate algorithm ID "' . $algorithm->getId() . '"', 0, $previous);
    }
}
