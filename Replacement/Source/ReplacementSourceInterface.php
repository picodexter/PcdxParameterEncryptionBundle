<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Replacement\Source;

/**
 * ReplacementSourceInterface.
 */
interface ReplacementSourceInterface
{
    /**
     * Get replaced value for the parameter.
     *
     * @param string $key
     * @param string $value
     * @return string|null
     */
    public function getReplacedValueForParameter($key, $value);

    /**
     * Check if this source is applicable for the parameter.
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function isApplicableForParameter($key, $value);
}
