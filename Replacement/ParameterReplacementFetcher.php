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

namespace Picodexter\ParameterEncryptionBundle\Replacement;

use Picodexter\ParameterEncryptionBundle\Replacement\Source\ReplacementSourceInterface;

class ParameterReplacementFetcher implements ParameterReplacementFetcherInterface
{
    /**
     * @var ReplacementSourceInterface[]
     */
    private $replacementSources;

    /**
     * Constructor.
     *
     * @param ReplacementSourceInterface[] $replacementSources
     */
    public function __construct(array $replacementSources)
    {
        $this->setReplacementSources($replacementSources);
    }

    /**
     * Setter: replacementSources.
     *
     * @param ReplacementSourceInterface[] $replacementSources
     */
    public function setReplacementSources(array $replacementSources)
    {
        $replacementSources = array_filter($replacementSources, function ($source) {
            return ($source instanceof ReplacementSourceInterface);
        });

        $this->replacementSources = $replacementSources;
    }

    /**
     * @inheritDoc
     */
    public function getReplacedValueForParameter($parameterKey, $parameterValue)
    {
        if (!\is_string($parameterValue)) {
            return null;
        }

        $replaced = false;

        foreach ($this->replacementSources as $source) {
            if ($source->isApplicableForParameter($parameterKey, $parameterValue)) {
                $parameterValue = $source->getReplacedValueForParameter($parameterKey, $parameterValue);
                $replaced = true;
            }
        }

        return ($replaced ? $parameterValue : null);
    }
}
