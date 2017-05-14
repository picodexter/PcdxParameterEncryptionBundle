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
 * AlgorithmConfiguration.
 */
class AlgorithmConfiguration
{
    /**
     * @var Algorithm[]
     */
    private $algorithms;

    /**
     * Constructor.
     *
     * @param Algorithm[] $algorithms
     */
    public function __construct(array $algorithms)
    {
        $this->setAlgorithms($algorithms);
    }

    /**
     * Getter: algorithms.
     *
     * @return Algorithm[]
     */
    public function getAlgorithms()
    {
        return $this->algorithms;
    }

    /**
     * Setter: algorithms.
     *
     * @param Algorithm[] $algorithms
     * @throws DuplicateAlgorithmIdException
     */
    public function setAlgorithms(array $algorithms)
    {
        /** @var Algorithm[] $validAlgorithms */
        $validAlgorithms = array_filter($algorithms, function ($algorithm) {
            return ($algorithm instanceof Algorithm);
        });

        $indexedAlgorithms = [];

        foreach ($validAlgorithms as $algorithm) {
            if (key_exists($algorithm->getId(), $indexedAlgorithms)) {
                throw new DuplicateAlgorithmIdException($algorithm);
            }

            $indexedAlgorithms[$algorithm->getId()] = $algorithm;
        }

        $this->algorithms = $indexedAlgorithms;
    }

    /**
     * Get algorithm by ID.
     *
     * @param string $id
     * @return Algorithm|null
     */
    public function get($id)
    {
        return ($this->has($id) ? $this->algorithms[$id] : null);
    }

    /**
     * Check if an algorithm with the ID is registered.
     *
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return key_exists($id, $this->algorithms);
    }
}
