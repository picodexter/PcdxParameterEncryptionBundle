<?php

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
 * MissingTagAttributeException.
 */
class MissingTagAttributeException extends DependencyInjectionException
{
    /**
     * @inheritDoc
     */
    public function __construct($tagName, $attributeName, Throwable $previous = null)
    {
        parent::__construct(sprintf('Missing attribute "%2$s" for tag "%1$s"', $tagName, $attributeName), 0, $previous);
    }
}
