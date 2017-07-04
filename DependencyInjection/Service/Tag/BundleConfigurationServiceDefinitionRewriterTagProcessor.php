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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * BundleConfigurationServiceDefinitionRewriterTagProcessor.
 */
class BundleConfigurationServiceDefinitionRewriterTagProcessor implements BundleConfigurationServiceDefinitionRewriterTagProcessorInterface
{
    const DEFAULT_PRIORITY = 0;
    const TAG_NAME = 'pcdx_parameter_encryption.bundle_configuration.service_definition_rewriter';

    /**
     * @var ReferenceFactoryInterface
     */
    private $referenceFactory;

    /**
     * Constructor.
     *
     * @param ReferenceFactoryInterface $referenceFactory
     */
    public function __construct(ReferenceFactoryInterface $referenceFactory)
    {
        $this->referenceFactory = $referenceFactory;
    }

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds(self::TAG_NAME);

        $rewriterReferences = [];

        foreach ($taggedServices as $taggedServiceId => $tags) {
            $rewriterReferences = $this->processTaggedService($rewriterReferences, $taggedServiceId, $tags);
        }

        krsort($rewriterReferences);

        $flattenedReferences = call_user_func_array('array_merge', $rewriterReferences);

        $this->injectRewritersIntoRegistry($container, $flattenedReferences);
    }

    /**
     * Process a tagged service.
     *
     * @param array  $rewriterReferences
     * @param string $taggedServiceId
     * @param array  $tags
     *
     * @return array
     */
    private function processTaggedService(array $rewriterReferences, $taggedServiceId, array $tags)
    {
        $priority = (
            array_key_exists(0, $tags) && array_key_exists('priority', $tags[0])
            ? (int) $tags[0]['priority']
            : self::DEFAULT_PRIORITY
        );

        if (!array_key_exists($priority, $rewriterReferences)) {
            $rewriterReferences[$priority] = [];
        }

        $rewriterReferences[$priority][] = $this->referenceFactory->createReference($taggedServiceId);

        return $rewriterReferences;
    }

    /**
     * Inject rewriters into registry.
     *
     * @param ContainerBuilder $container
     * @param array            $references
     */
    private function injectRewritersIntoRegistry(ContainerBuilder $container, array $references)
    {
        $registryDefinition = $container
            ->getDefinition(ServiceNames::BUNDLE_CONFIGURATION_SERVICE_DEFINITION_REWRITER_REGISTRY);

        $arguments = $registryDefinition->getArguments();

        $arguments[0] = $references;

        $registryDefinition->setArguments($arguments);
    }
}
