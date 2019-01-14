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

namespace Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection;

use Throwable;

/**
 * UnknownClassException.
 */
class UnknownClassException extends DependencyInjectionException
{
    /**
     * Constructor.
     *
     * @param string         $className
     * @param Throwable|null $previous
     */
    public function __construct($className, Throwable $previous = null)
    {
        parent::__construct(sprintf('Unknown class "%s"', $className), 0, $previous);
    }
}
