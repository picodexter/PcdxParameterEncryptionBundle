<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration;

use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * DummyConfiguration.
 *
 * This class only exists for usage as a class dummy value for Symfony service definitions when using the
 * ConfigurationFactory.
 */
class DummyConfiguration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
    }
}
