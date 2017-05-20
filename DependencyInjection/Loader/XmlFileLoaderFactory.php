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

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * XmlFileLoaderFactory.
 */
class XmlFileLoaderFactory implements XmlFileLoaderFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createXmlFileLoader(ContainerBuilder $container, FileLocatorInterface $locator)
    {
        return new XmlFileLoader($container, $locator);
    }
}
