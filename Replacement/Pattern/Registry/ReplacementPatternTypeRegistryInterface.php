<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Replacement\Pattern\Registry;

/**
 * ReplacementPatternTypeRegistryInterface.
 */
interface ReplacementPatternTypeRegistryInterface
{
    /**
     * Getter: patternTypes.
     *
     * @return string[]
     */
    public function getPatternTypes();

    /**
     * Setter: patternTypes.
     *
     * @param string[] $patternTypes
     */
    public function setPatternTypes(array $patternTypes);

    /**
     * Get pattern type by name.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function get($name);

    /**
     * Check if a pattern type with the name is registered.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name);
}
