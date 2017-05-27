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
 * InvalidAlgorithmIdException.
 */
class InvalidAlgorithmIdException extends ConfigurationException
{
    /**
     * Constructor.
     *
     * @param string         $algorithmId
     * @param Throwable|null $previous
     */
    public function __construct($algorithmId, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Invalid algorithm ID "%s". Must only contain characters: [a-zA-Z0-9_.]', $algorithmId),
            0,
            $previous
        );
    }
}
