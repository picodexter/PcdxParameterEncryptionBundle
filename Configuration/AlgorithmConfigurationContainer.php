<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration;

use Picodexter\ParameterEncryptionBundle\Exception\Configuration\DuplicateAlgorithmIdException;

/**
 * AlgorithmConfigurationContainer.
 */
class AlgorithmConfigurationContainer implements AlgorithmConfigurationContainerInterface
{
    /**
     * @var AlgorithmConfiguration[]
     */
    private $algorithmConfigurations;

    /**
     * Constructor.
     *
     * @param AlgorithmConfiguration[] $algorithms
     */
    public function __construct(array $algorithms)
    {
        $this->setAlgorithmConfigurations($algorithms);
    }

    /**
     * @inheritDoc
     */
    public function getAlgorithmConfigurations()
    {
        return $this->algorithmConfigurations;
    }

    /**
     * @inheritDoc
     */
    public function setAlgorithmConfigurations(array $algorithmConfigs)
    {
        /** @var AlgorithmConfiguration[] $validAlgorithms */
        $validAlgorithms = array_filter($algorithmConfigs, function ($algorithm) {
            return ($algorithm instanceof AlgorithmConfiguration);
        });

        $indexedAlgorithms = [];

        foreach ($validAlgorithms as $algorithm) {
            if (key_exists($algorithm->getId(), $indexedAlgorithms)) {
                throw new DuplicateAlgorithmIdException($algorithm);
            }

            $indexedAlgorithms[$algorithm->getId()] = $algorithm;
        }

        $this->algorithmConfigurations = $indexedAlgorithms;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        return ($this->has($id) ? $this->algorithmConfigurations[$id] : null);
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return key_exists($id, $this->algorithmConfigurations);
    }
}
