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
 * InvalidBundleConfigurationException.
 */
class InvalidBundleConfigurationException extends ConfigurationException
{
    /**
     * Constructor.
     *
     * @param Throwable|null $previous
     */
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Invalid bundle configuration', 0, $previous);
    }
}
