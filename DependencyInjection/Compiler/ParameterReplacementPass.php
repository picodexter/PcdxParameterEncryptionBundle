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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ParameterReplacementPass.
 *
 * Compiler pass to replace encrypted parameter values with the decrypted ones.
 */
class ParameterReplacementPass implements CompilerPassInterface
{
    /**
     * Process container.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $parameterBag = $container->getParameterBag();

        $parameterReplacer = $container->get(ServiceNames::PARAMETER_REPLACER);

        $parameterReplacer->processParameterBag($parameterBag, $container);
    }
}
