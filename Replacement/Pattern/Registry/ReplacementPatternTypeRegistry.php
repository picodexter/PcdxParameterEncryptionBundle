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
 * ReplacementPatternTypeRegistry.
 */
class ReplacementPatternTypeRegistry
{
    /**
     * @var string[]
     */
    private $patternTypes;

    /**
     * Constructor.
     *
     * @param string[] $patternTypes
     */
    public function __construct(array $patternTypes)
    {
        $this->patternTypes = $patternTypes;
    }

    /**
     * Getter: patternTypes.
     *
     * @return string[]
     */
    public function getPatternTypes()
    {
        return $this->patternTypes;
    }

    /**
     * Setter: patternTypes.
     *
     * @param string[] $patternTypes
     */
    public function setPatternTypes(array $patternTypes)
    {
        $this->patternTypes = $patternTypes;
    }

    /**
     * Get pattern type by name.
     *
     * @param string $name
     * @return string|null
     */
    public function get($name)
    {
        return ($this->has($name) ? $this->patternTypes[$name] : null);
    }

    /**
     * Check if a pattern type with the name is registered.
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return key_exists($name, $this->patternTypes);
    }
}
