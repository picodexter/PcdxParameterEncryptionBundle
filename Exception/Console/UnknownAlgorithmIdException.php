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

namespace Picodexter\ParameterEncryptionBundle\Exception\Console;

use Throwable;

/**
 * UnknownAlgorithmIdException.
 */
class UnknownAlgorithmIdException extends InvalidConsoleInputException
{
    /**
     * Constructor.
     *
     * @param string         $algorithmId
     * @param Throwable|null $previous
     */
    public function __construct($algorithmId, Throwable $previous = null)
    {
        parent::__construct(sprintf('Unknown algorithm ID "%s"', $algorithmId), 0, $previous);
    }
}
