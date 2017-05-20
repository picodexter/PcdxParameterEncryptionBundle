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

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * BundleServiceDefinitionsLoader.
 */
class BundleServiceDefinitionsLoader implements BundleServiceDefinitionsLoaderInterface
{
    const SERVICES_CONFIG_DIRECTORY_RELATIVE_PATH = __DIR__ . '/../../Resources/config';

    /**
     * @var FileLocatorFactoryInterface
     */
    private $fileLocatorFactory;

    /**
     * @var XmlFileLoaderFactoryInterface
     */
    private $xmlFileLoaderFactory;

    /**
     * Constructor.
     *
     * @param FileLocatorFactoryInterface   $fileLocatorFactory
     * @param XmlFileLoaderFactoryInterface $xmlFileLoaderFactory
     */
    public function __construct(
        FileLocatorFactoryInterface $fileLocatorFactory,
        XmlFileLoaderFactoryInterface $xmlFileLoaderFactory
    ) {
        $this->fileLocatorFactory = $fileLocatorFactory;
        $this->xmlFileLoaderFactory = $xmlFileLoaderFactory;
    }

    /**
     * Load bundle service definitions.
     *
     * @param ContainerBuilder $container
     */
    public function loadBundleServiceDefinitions(ContainerBuilder $container)
    {
        $fileLocator = $this->fileLocatorFactory->createFileLocator(self::SERVICES_CONFIG_DIRECTORY_RELATIVE_PATH);

        $loader = $this->xmlFileLoaderFactory->createXmlFileLoader($container, $fileLocator);

        $loader->load('services.xml');
    }
}
