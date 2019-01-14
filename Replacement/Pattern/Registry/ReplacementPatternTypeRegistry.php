<?php

declare(strict_types=1);

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
class ReplacementPatternTypeRegistry implements ReplacementPatternTypeRegistryInterface
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
     * @inheritDoc
     */
    public function getPatternTypes()
    {
        return $this->patternTypes;
    }

    /**
     * @inheritDoc
     */
    public function setPatternTypes(array $patternTypes)
    {
        $this->patternTypes = $patternTypes;
    }

    /**
     * @inheritDoc
     */
    public function get($name)
    {
        return ($this->has($name) ? $this->patternTypes[$name] : null);
    }

    /**
     * @inheritDoc
     */
    public function has($name)
    {
        return array_key_exists($name, $this->patternTypes);
    }
}
