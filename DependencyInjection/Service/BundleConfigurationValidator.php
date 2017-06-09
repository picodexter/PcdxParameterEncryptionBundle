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

use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException;

/**
 * BundleConfigurationValidator.
 */
class BundleConfigurationValidator implements BundleConfigurationValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function assertValidBundleConfiguration(array $bundleConfig)
    {
        if (!array_key_exists('algorithms', $bundleConfig) || !is_array($bundleConfig['algorithms'])) {
            throw new InvalidBundleConfigurationException();
        }
    }
}
