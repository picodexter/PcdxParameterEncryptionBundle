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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterManagerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ServiceDefinitionProcessor.
 */
class ServiceDefinitionProcessor implements ServiceDefinitionProcessorInterface
{
    /**
     * @var RewriterManagerInterface
     */
    private $rewriterManager;

    /**
     * Constructor.
     *
     * @param RewriterManagerInterface $rewriterManager
     */
    public function __construct(RewriterManagerInterface $rewriterManager)
    {
        $this->rewriterManager = $rewriterManager;
    }

    /**
     * @inheritDoc
     */
    public function processServiceDefinitions(ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $serviceId => $definition) {
            $this->rewriterManager->processServiceDefinition($serviceId, $definition, $container);
        }
    }
}
