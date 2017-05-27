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
 * ReplacementPatternRegistryInterface.
 */
interface ReplacementPatternRegistryInterface
{
    /**
     * Getter: replacementPatterns.
     *
     * @return ReplacementPatternInterface[]
     */
    public function getReplacementPatterns();

    /**
     * Setter: replacementPatterns.
     *
     * @param ReplacementPatternInterface[] $replacementPatterns
     */
    public function setReplacementPatterns(array $replacementPatterns);

    /**
     * Get replacement pattern by algorithm ID.
     *
     * @param string $algorithmId
     *
     * @return string|null
     */
    public function get($algorithmId);

    /**
     * Check if a replacement pattern with the algorithm ID is registered.
     *
     * @param string $algorithmId
     *
     * @return bool
     */
    public function has($algorithmId);
}
