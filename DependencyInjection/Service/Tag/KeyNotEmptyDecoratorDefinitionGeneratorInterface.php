<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag;

use Symfony\Component\DependencyInjection\Definition;

/**
 * KeyNotEmptyDecoratorDefinitionGeneratorInterface.
 */
interface KeyNotEmptyDecoratorDefinitionGeneratorInterface
{
    /**
     * Create decorator definition.
     *
     * @param string $decoratorClass
     * @param string $decoratorServiceId
     * @param string $decoratedServiceId
     * @param int    $decorationPriority
     *
     * @return Definition
     */
    public function createDecoratorDefinition(
        $decoratorClass,
        $decoratorServiceId,
        $decoratedServiceId,
        $decorationPriority
    );
}
