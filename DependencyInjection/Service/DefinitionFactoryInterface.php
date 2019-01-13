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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service;

use Symfony\Component\DependencyInjection\Definition;

/**
 * DefinitionFactoryInterface.
 */
interface DefinitionFactoryInterface
{
    /**
     * Create definition for a Symfony service.
     *
     * @param string|null $class     The service class
     * @param array       $arguments An array of arguments to pass to the service constructor
     *
     * @return Definition
     */
    public function createDefinition($class = null, array $arguments = []);
}
