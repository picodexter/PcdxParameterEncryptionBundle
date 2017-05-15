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

use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

/**
 * ReplacementPatternRegistry.
 */
class ReplacementPatternRegistry
{
    /**
     * @var ReplacementPatternInterface[]
     */
    private $replacementPatterns;

    /**
     * Constructor.
     *
     * @param ReplacementPatternInterface[] $replacementPatterns
     */
    public function __construct(array $replacementPatterns)
    {
        $this->setReplacementPatterns($replacementPatterns);
    }

    /**
     * Getter: replacementPatterns.
     *
     * @return ReplacementPatternInterface[]
     */
    public function getReplacementPatterns()
    {
        return $this->replacementPatterns;
    }

    /**
     * Setter: replacementPatterns.
     *
     * @param ReplacementPatternInterface[] $replacementPatterns
     */
    public function setReplacementPatterns(array $replacementPatterns)
    {
        $validPatterns = array_filter($replacementPatterns, function ($replacementPattern) {
            return ($replacementPattern instanceof ReplacementPatternInterface);
        });

        $this->replacementPatterns = $validPatterns;
    }

    /**
     * Get replacement pattern by algorithm ID.
     *
     * @param string $algorithmId
     * @return string|null
     */
    public function get($algorithmId)
    {
        return ($this->has($algorithmId) ? $this->replacementPatterns[$algorithmId] : null);
    }

    /**
     * Check if a replacement pattern with the algorithm ID is registered.
     *
     * @param string $algorithmId
     * @return bool
     */
    public function has($algorithmId)
    {
        return key_exists($algorithmId, $this->replacementPatterns);
    }
}
