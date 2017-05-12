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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\ContainerBuilderFactory;
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
     * @var ContainerBuilder
     */
    private $passContainer;

    /**
     * Constructor.
     *
     * @param ContainerBuilder $passContainer
     */
    public function __construct(ContainerBuilder $passContainer = null)
    {
        $this->setPassContainer($passContainer);
    }

    /**
     * Setter: pass container.
     *
     * @param ContainerBuilder $passContainer
     */
    public function setPassContainer(ContainerBuilder $passContainer = null)
    {
        if ($passContainer) {
            $this->passContainer = $passContainer;
        } else {
            $this->passContainer = ContainerBuilderFactory::createContainerBuilder();
        }
    }

    /**
     * Process container.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $parameterBag = $container->getParameterBag();

        $parameterReplacer = $this->passContainer->get('pcdx_parameter_encryption.replacement.parameter_replacer');

        $parameterReplacer->processParameterBag($parameterBag);
    }
}
