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

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * KeyNotEmptyTagProcessor.
 */
class KeyNotEmptyTagProcessor implements KeyNotEmptyTagProcessorInterface
{
    const DECORATOR_SERVICE_ID_SUFFIX = '.decorator.key_not_empty';
    const DEFAULT_DECORATION_PRIORITY = 1000;
    const TAG_NAME = 'pcdx_parameter_encryption.crypto.key_must_not_be_empty';

    /**
     * @var KeyNotEmptyDecoratorClassResolverInterface
     */
    private $decoratorClassResolver;

    /**
     * @var KeyNotEmptyDecoratorDefinitionGeneratorInterface
     */
    private $decoratorDefinitionGenerator;

    /**
     * Constructor.
     *
     * @param KeyNotEmptyDecoratorClassResolverInterface       $decoratorClassResolv
     * @param KeyNotEmptyDecoratorDefinitionGeneratorInterface $decoratorGenerator
     */
    public function __construct(
        KeyNotEmptyDecoratorClassResolverInterface $decoratorClassResolv,
        KeyNotEmptyDecoratorDefinitionGeneratorInterface $decoratorGenerator
    ) {
        $this->decoratorClassResolver = $decoratorClassResolv;
        $this->decoratorDefinitionGenerator = $decoratorGenerator;
    }

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds(self::TAG_NAME);

        foreach ($taggedServices as $taggedServiceId => $tag) {
            $this->processTaggedService($container, $taggedServiceId, $tag);
        }
    }

    /**
     * Process a tagged service.
     *
     * @param ContainerBuilder $container
     * @param string           $taggedServiceId
     * @param array            $tag
     */
    private function processTaggedService(ContainerBuilder $container, $taggedServiceId, array $tag)
    {
        $taggedDefinition = $container->getDefinition($taggedServiceId);

        $decoratorServiceId = $taggedServiceId.self::DECORATOR_SERVICE_ID_SUFFIX;
        $decoratorClass = $this->decoratorClassResolver
            ->getDecoratorClassForDecoratedClass($taggedDefinition->getClass());
        $decorationPriority = (
            array_key_exists('priority', $tag)
            ? $tag['priority']
            : self::DEFAULT_DECORATION_PRIORITY
        );

        $decoratorDefinition = $this->decoratorDefinitionGenerator->createDecoratorDefinition(
            $decoratorClass,
            $decoratorServiceId,
            $taggedServiceId,
            $decorationPriority
        );

        $container->setDefinition($decoratorServiceId, $decoratorDefinition);
    }
}
