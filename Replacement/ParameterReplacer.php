<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Replacement;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * ParameterReplacer.
 */
class ParameterReplacer implements ParameterReplacerInterface
{
    /**
     * @var ParameterReplacementFetcherInterface
     */
    private $replacementFetcher;

    /**
     * Constructor.
     *
     * @param ParameterReplacementFetcherInterface $replacementFetcher
     */
    public function __construct(ParameterReplacementFetcherInterface $replacementFetcher)
    {
        $this->replacementFetcher = $replacementFetcher;
    }

    /**
     * @inheritDoc
     */
    public function processParameterBag(ParameterBagInterface $parameterBag)
    {
        $parameters = $parameterBag->all();

        $parameters = $this->processParameters($parameters);

        $parameterBag->clear();
        $parameterBag->add($parameters);

        return $parameterBag;
    }

    /**
     * Process parameter array.
     *
     * @param array $parameters
     *
     * @return array
     */
    public function processParameters(array $parameters)
    {
        foreach ($parameters as $parameterKey => &$parameterValue) {
            if (is_array($parameterValue)) {
                $parameterValue = $this->processParameters($parameterValue);
                continue;
            }

            $replacementValue = $this->replacementFetcher->getReplacedValueForParameter($parameterKey, $parameterValue);

            if (null !== $replacementValue) {
                $parameterValue = $replacementValue;
            }
        }

        return $parameters;
    }
}
