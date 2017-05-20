<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Loader;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader\BundleServiceDefinitionsLoaderFactory;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader\BundleServiceDefinitionsLoaderInterface;

class BundleServiceDefinitionsLoaderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateBundleServiceDefinitionsLoader()
    {
        $loader = BundleServiceDefinitionsLoaderFactory::createBundleServiceDefinitionsLoader();

        $this->assertInstanceOf(BundleServiceDefinitionsLoaderInterface::class, $loader);
    }
}
