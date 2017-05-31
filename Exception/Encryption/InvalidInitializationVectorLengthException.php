<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Exception\Encryption;

use Throwable;

/**
 * InvalidInitializationVectorLengthException.
 */
class InvalidInitializationVectorLengthException extends EncryptionException
{
    /**
     * Constructor.
     *
     * @param Throwable|null $previous
     */
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Invalid initialization vector length', 0, $previous);
    }
}
