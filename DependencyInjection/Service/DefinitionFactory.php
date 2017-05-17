<?php

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
 * DefinitionFactory.
 */
class DefinitionFactory implements DefinitionFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createDefinition($class = null, array $arguments = [])
    {
        return new Definition($class, $arguments);
    }
}
