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

use Picodexter\ParameterEncryptionBundle\Exception\ExceptionInterface;
use Picodexter\ParameterEncryptionBundle\Exception\RuntimeException;

/**
 * ConfigurationException.
 */
class ConfigurationException extends RuntimeException implements ExceptionInterface
{
}
