<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Compiler;

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

        $parameterReplacer = $container->get('pcdx_parameter_encryption.replacement.parameter_replacer');

        $parameterReplacer->processParameterBag($parameterBag);
    }
}
