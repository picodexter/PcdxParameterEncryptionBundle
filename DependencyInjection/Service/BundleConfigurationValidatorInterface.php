<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service;

use Picodexter\ParameterEncryptionBundle\Exception\InvalidBundleConfigurationException;

/**
 * BundleConfigurationValidatorInterface.
 */
interface BundleConfigurationValidatorInterface
{
    /**
     * Assert that bundle configuration has a valid structure.
     *
     * @param array $bundleConfig
     * @throws InvalidBundleConfigurationException
     */
    public function assertValidBundleConfiguration(array $bundleConfig);
}
