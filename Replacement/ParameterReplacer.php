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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\EnvironmentPlaceholderResolverInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * ParameterReplacer.
 */
class ParameterReplacer implements ParameterReplacerInterface
{
    /**
     * @var EnvironmentPlaceholderResolverInterface
     */
    private $environmentPlaceholderResolver;

    /**
     * @var ParameterReplacementFetcherInterface
     */
    private $replacementFetcher;

    /**
     * Constructor.
     *
     * @param EnvironmentPlaceholderResolverInterface $environmentPlaceholderResolver
     * @param ParameterReplacementFetcherInterface    $replacementFetcher
     */
    public function __construct(
        EnvironmentPlaceholderResolverInterface $environmentPlaceholderResolver,
        ParameterReplacementFetcherInterface $replacementFetcher
    ) {
        $this->environmentPlaceholderResolver = $environmentPlaceholderResolver;
        $this->replacementFetcher = $replacementFetcher;
    }

    /**
     * @inheritDoc
     */
    public function processParameterBag(ParameterBagInterface $parameterBag, ContainerBuilder $container)
    {
        $parameters = $parameterBag->all();

        $parameters = $this->processParameters($parameters, $container);

        $parameterBag->clear();
        $parameterBag->add($parameters);

        return $parameterBag;
    }

    /**
     * Process parameter array.
     *
     * @param array            $parameters
     * @param ContainerBuilder $container
     *
     * @return array
     */
    public function processParameters(array $parameters, ContainerBuilder $container)
    {
        foreach ($parameters as $parameterKey => &$parameterValue) {
            if (is_array($parameterValue)) {
                $parameterValue = $this->processParameters($parameterValue, $container);
                continue;
            }

            $resolvedValue = $this->environmentPlaceholderResolver
                ->resolveEnvironmentPlaceholders($parameterValue, $container);

            $replacementValue = $this->replacementFetcher->getReplacedValueForParameter($parameterKey, $resolvedValue);

            if (null !== $replacementValue) {
                $parameterValue = $replacementValue;
            }
        }

        return $parameters;
    }
}
