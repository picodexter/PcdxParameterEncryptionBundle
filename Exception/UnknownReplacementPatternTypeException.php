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
 * UnknownReplacementPatternTypeException.
 */
class UnknownReplacementPatternTypeException extends ConfigurationException
{
    /**
     * Constructor.
     *
     * @param string         $patternType
     * @param Throwable|null $previous
     */
    public function __construct($patternType, Throwable $previous = null)
    {
        parent::__construct('Unknown replacement pattern type "' . $patternType . '"', 0, $previous);
    }
}
