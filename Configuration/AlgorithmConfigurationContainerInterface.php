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

namespace Picodexter\ParameterEncryptionBundle\Configuration;

use Picodexter\ParameterEncryptionBundle\Exception\Configuration\DuplicateAlgorithmIdException;

/**
 * AlgorithmConfigurationContainerInterface.
 */
interface AlgorithmConfigurationContainerInterface
{
    /**
     * Getter: algorithmConfigurations.
     *
     * @return AlgorithmConfiguration[]
     */
    public function getAlgorithmConfigurations();

    /**
     * Setter: algorithmConfigurations.
     *
     * @param AlgorithmConfiguration[] $algorithmConfigs
     *
     * @throws DuplicateAlgorithmIdException
     */
    public function setAlgorithmConfigurations(array $algorithmConfigs);

    /**
     * Get algorithm by ID.
     *
     * @param string $id
     *
     * @return AlgorithmConfiguration|null
     */
    public function get($id);

    /**
     * Check if an algorithm with the ID is registered.
     *
     * @param string $id
     *
     * @return bool
     */
    public function has($id);
}
