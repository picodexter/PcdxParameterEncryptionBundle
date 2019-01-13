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

namespace Picodexter\ParameterEncryptionBundle\Exception\Configuration;

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
        parent::__construct(sprintf('Unknown replacement pattern type "%s"', $patternType), 0, $previous);
    }
}
