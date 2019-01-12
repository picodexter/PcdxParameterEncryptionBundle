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
use Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection\MissingTagAttributeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * BundleConfigurationServiceDefinitionRewriterTagProcessor.
 */
class BundleConfigurationServiceDefinitionRewriterTagProcessor implements BundleConfigurationServiceDefinitionRewriterTagProcessorInterface
{
    const DEFAULT_PRIORITY = 0;
    const TAG_ATTRIBUTE_EXTENSION_CONFIGURATION_KEY = 'extension_configuration_key';
    const TAG_ATTRIBUTE_PRIORITY = 'priority';
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
            $rewriterReferences = $this->processTaggedService($container, $rewriterReferences, $taggedServiceId, $tags);
        }

        if (\count($rewriterReferences) > 0) {
            krsort($rewriterReferences);

            $flattenedReferences = \call_user_func_array('array_merge', $rewriterReferences);
        } else {
            $flattenedReferences = [];
        }

        $this->injectRewritersIntoRegistry($container, $flattenedReferences);
    }

    /**
     * Add rewriter reference by priority.
     *
     * @param array  $rewriterReferences
     * @param string $taggedServiceId
     * @param array  $tag
     *
     * @return array
     */
    private function addRewriterReferenceByPriority(array $rewriterReferences, $taggedServiceId, array $tag)
    {
        $priority = (
            array_key_exists(self::TAG_ATTRIBUTE_PRIORITY, $tag)
            ? (int) $tag[self::TAG_ATTRIBUTE_PRIORITY]
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

    /**
     * Process a tagged service.
     *
     * @param ContainerBuilder $container
     * @param array            $rewriterReferences
     * @param string           $taggedServiceId
     * @param array            $tags
     *
     * @throws MissingTagAttributeException
     *
     * @return array
     */
    private function processTaggedService(
        ContainerBuilder $container,
        array $rewriterReferences,
        $taggedServiceId,
        array $tags
    ) {
        $firstTag = $tags[0];

        if (!array_key_exists(self::TAG_ATTRIBUTE_EXTENSION_CONFIGURATION_KEY, $firstTag)) {
            throw new MissingTagAttributeException(self::TAG_NAME, self::TAG_ATTRIBUTE_EXTENSION_CONFIGURATION_KEY);
        }

        $extensionConfigKey = $firstTag[self::TAG_ATTRIBUTE_EXTENSION_CONFIGURATION_KEY];

        if (\count($container->getExtensionConfig($extensionConfigKey)) < 1) {
            return $rewriterReferences;
        }

        $this->setExtensionConfigurationKeyForRewriter($container, $taggedServiceId, $extensionConfigKey);

        $rewriterReferences = $this->addRewriterReferenceByPriority($rewriterReferences, $taggedServiceId, $firstTag);

        return $rewriterReferences;
    }

    /**
     * Set extension configuration key for rewriter.
     *
     * @param ContainerBuilder $container
     * @param string           $rewriterServiceId
     * @param string           $extensionConfigKey
     */
    private function setExtensionConfigurationKeyForRewriter(
        ContainerBuilder $container,
        $rewriterServiceId,
        $extensionConfigKey
    ) {
        $rewriterDefinition = $container->getDefinition($rewriterServiceId);

        $methodCalls = $rewriterDefinition->getMethodCalls();

        $methodCalls[] = ['setExtensionConfigurationKey', [$extensionConfigKey]];

        $rewriterDefinition->setMethodCalls($methodCalls);
    }
}
