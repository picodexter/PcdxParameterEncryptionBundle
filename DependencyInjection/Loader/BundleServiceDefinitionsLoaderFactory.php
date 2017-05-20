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

/**
 * BundleServiceDefinitionsLoaderFactory.
 */
class BundleServiceDefinitionsLoaderFactory
{
    /**
     * Create bundle service definitions loader.
     *
     * @return BundleServiceDefinitionsLoader
     */
    public static function createBundleServiceDefinitionsLoader()
    {
        $fileLocatorFactory = new FileLocatorFactory();
        $xmlFileLoaderFactory = new XmlFileLoaderFactory();

        return new BundleServiceDefinitionsLoader($fileLocatorFactory, $xmlFileLoaderFactory);
    }
}
