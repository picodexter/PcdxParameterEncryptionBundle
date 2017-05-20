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

use Picodexter\ParameterEncryptionBundle\Exception\DuplicateAlgorithmIdException;

/**
 * AlgorithmConfigurationContainer.
 */
class AlgorithmConfigurationContainer
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
     * Getter: algorithmConfigurations.
     *
     * @return AlgorithmConfiguration[]
     */
    public function getAlgorithmConfigurations()
    {
        return $this->algorithmConfigurations;
    }

    /**
     * Setter: algorithmConfigurations.
     *
     * @param AlgorithmConfiguration[] $algorithmConfigurations
     * @throws DuplicateAlgorithmIdException
     */
    public function setAlgorithmConfigurations(array $algorithmConfigurations)
    {
        /** @var AlgorithmConfiguration[] $validAlgorithms */
        $validAlgorithms = array_filter($algorithmConfigurations, function ($algorithm) {
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
     * Get algorithm by ID.
     *
     * @param string $id
     * @return AlgorithmConfiguration|null
     */
    public function get($id)
    {
        return ($this->has($id) ? $this->algorithmConfigurations[$id] : null);
    }

    /**
     * Check if an algorithm with the ID is registered.
     *
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return key_exists($id, $this->algorithmConfigurations);
    }
}
