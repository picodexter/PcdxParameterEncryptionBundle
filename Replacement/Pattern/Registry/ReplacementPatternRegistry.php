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

class ReplacementPatternRegistry implements ReplacementPatternRegistryInterface
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
     * @inheritDoc
     */
    public function getReplacementPatterns()
    {
        return $this->replacementPatterns;
    }

    /**
     * @inheritDoc
     */
    public function setReplacementPatterns(array $replacementPatterns)
    {
        $validPatterns = array_filter($replacementPatterns, function ($replacementPattern) {
            return ($replacementPattern instanceof ReplacementPatternInterface);
        });

        $this->replacementPatterns = $validPatterns;
    }

    /**
     * @inheritDoc
     */
    public function get($algorithmId)
    {
        return ($this->has($algorithmId) ? $this->replacementPatterns[$algorithmId] : null);
    }

    /**
     * @inheritDoc
     */
    public function has($algorithmId)
    {
        return array_key_exists($algorithmId, $this->replacementPatterns);
    }
}
