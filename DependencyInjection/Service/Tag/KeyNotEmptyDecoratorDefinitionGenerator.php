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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;

/**
 * KeyNotEmptyDecoratorDefinitionGenerator.
 */
class KeyNotEmptyDecoratorDefinitionGenerator implements KeyNotEmptyDecoratorDefinitionGeneratorInterface
{
    /**
     * @var DefinitionFactoryInterface
     */
    private $definitionFactory;

    /**
     * @var ReferenceFactoryInterface
     */
    private $referenceFactory;

    /**
     * Constructor.
     *
     * @param DefinitionFactoryInterface $definitionFactory
     * @param ReferenceFactoryInterface  $referenceFactory
     */
    public function __construct(
        DefinitionFactoryInterface $definitionFactory,
        ReferenceFactoryInterface $referenceFactory
    ) {
        $this->definitionFactory = $definitionFactory;
        $this->referenceFactory = $referenceFactory;
    }

    /**
     * @inheritDoc
     */
    public function createDecoratorDefinition(
        $decoratorClass,
        $decoratorServiceId,
        $decoratedServiceId,
        $decorationPriority
    ) {
        $decorationPriority = (int) $decorationPriority;

        $decoratedServiceRef = $this->referenceFactory->createReference($decoratorServiceId.'.inner');
        $validatorReference = $this->referenceFactory->createReference(ServiceNames::KEY_VALIDATOR_NOT_EMPTY);

        $decoratorDefinition = $this->definitionFactory
            ->createDefinition($decoratorClass, [$decoratedServiceRef, $validatorReference]);

        $decoratorDefinition->setDecoratedService($decoratedServiceId, null, $decorationPriority);
        $decoratorDefinition->setPublic(false);

        return $decoratorDefinition;
    }
}
