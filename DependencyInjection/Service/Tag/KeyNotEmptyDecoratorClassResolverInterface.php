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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag;

/**
 * KeyNotEmptyDecoratorClassResolverInterface.
 */
interface KeyNotEmptyDecoratorClassResolverInterface
{
    /**
     * Get decorator class for decorated class.
     *
     * @param string $serviceClass
     *
     * @return string
     */
    public function getDecoratorClassForDecoratedClass($serviceClass);
}
