<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidatorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\UnknownReplacementPatternTypeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ReplacementPatternRegistrationHandler.
 */
class ReplacementPatternRegistrationHandler implements ReplacementPatternRegistrationHandlerInterface
{
    /**
     * @var BundleConfigurationValidatorInterface
     */
    private $bundleConfigValidator;

    /**
     * @var DefinitionFactoryInterface
     */
    private $definitionFactory;

    /**
     * @var ServiceNameGeneratorInterface
     */
    private $serviceNameGenerator;

    /**
     * Constructor.
     *
     * @param BundleConfigurationValidatorInterface $configValidator
     * @param DefinitionFactoryInterface            $definitionFactory
     * @param ServiceNameGeneratorInterface         $serviceNameGenerator
     */
    public function __construct(
        BundleConfigurationValidatorInterface $configValidator,
        DefinitionFactoryInterface $definitionFactory,
        ServiceNameGeneratorInterface $serviceNameGenerator
    ) {
        $this->bundleConfigValidator = $configValidator;
        $this->definitionFactory = $definitionFactory;
        $this->serviceNameGenerator = $serviceNameGenerator;
    }

    /**
     * @inheritDoc
     */
    public function registerReplacementPatterns(array $bundleConfig, ContainerBuilder $container)
    {
        $this->bundleConfigValidator->assertValidBundleConfiguration($bundleConfig);

        $patternTypeRegistry = $container->get(ServiceNames::REPLACEMENT_PATTERN_TYPE_REGISTRY);

        $serviceDefinitions = [];

        foreach ($bundleConfig['algorithms'] as $algorithmConfig) {
            $patternType = $algorithmConfig['pattern']['type'];

            if (!$patternTypeRegistry->has($patternType)) {
                throw new UnknownReplacementPatternTypeException($patternType);
            }

            $serviceName = $this->serviceNameGenerator->getReplacementPatternServiceNameForAlgorithm($algorithmConfig);

            $serviceDefinition = $this->definitionFactory->createDefinition(
                $patternTypeRegistry->get($patternType),
                $algorithmConfig['pattern']['arguments']
            );

            $serviceDefinitions[$serviceName] = $serviceDefinition;
        }

        $container->addDefinitions($serviceDefinitions);
    }
}
