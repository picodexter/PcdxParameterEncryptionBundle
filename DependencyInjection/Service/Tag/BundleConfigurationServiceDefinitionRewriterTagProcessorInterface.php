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

use Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection\MissingTagAttributeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * BundleConfigurationServiceDefinitionRewriterTagProcessor.
 */
interface BundleConfigurationServiceDefinitionRewriterTagProcessorInterface
{
    /**
     * Process container.
     *
     * @param ContainerBuilder $container
     *
     * @throws MissingTagAttributeException
     */
    public function process(ContainerBuilder $container);
}
