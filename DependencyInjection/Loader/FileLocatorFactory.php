<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader;

use Symfony\Component\Config\FileLocator;

/**
 * FileLocatorFactory.
 */
class FileLocatorFactory implements FileLocatorFactoryInterface
{
    public function createFileLocator($paths = array())
    {
        return new FileLocator($paths);
    }
}
