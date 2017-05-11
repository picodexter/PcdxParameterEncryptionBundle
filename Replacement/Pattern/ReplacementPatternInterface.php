<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Replacement\Pattern;

/**
 * ReplacementPatternInterface.
 */
interface ReplacementPatternInterface
{
    /**
     * Get part of value that should be replaced.
     *
     * @param string $key
     * @param string $value
     * @return string|null
     */
    public function getValueWithoutPatternForParameter($key, $value);

    /**
     * Check if this source is applicable for the parameter.
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function isApplicableForParameter($key, $value);
}
