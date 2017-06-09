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

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfiguration;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidatorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AlgorithmRegistrationHandler implements AlgorithmRegistrationHandlerInterface
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
     * @var ReferenceFactoryInterface
     */
    private $referenceFactory;

    /**
     * @var ServiceNameGeneratorInterface
     */
    private $serviceNameGenerator;

    /**
     * Constructor.
     *
     * @param BundleConfigurationValidatorInterface $configValidator
     * @param DefinitionFactoryInterface            $definitionFactory
     * @param ReferenceFactoryInterface             $referenceFactory
     * @param ServiceNameGeneratorInterface         $serviceNameGenerator
     */
    public function __construct(
        BundleConfigurationValidatorInterface $configValidator,
        DefinitionFactoryInterface $definitionFactory,
        ReferenceFactoryInterface $referenceFactory,
        ServiceNameGeneratorInterface $serviceNameGenerator
    ) {
        $this->bundleConfigValidator = $configValidator;
        $this->definitionFactory = $definitionFactory;
        $this->referenceFactory = $referenceFactory;
        $this->serviceNameGenerator = $serviceNameGenerator;
    }

    /**
     * @inheritDoc
     */
    public function registerAlgorithms(array $bundleConfig, ContainerBuilder $container)
    {
        $this->bundleConfigValidator->assertValidBundleConfiguration($bundleConfig);

        $algorithmDefinitions = [];

        foreach ($bundleConfig['algorithms'] as $algorithmConfig) {
            $serviceName = $this->serviceNameGenerator
                ->getAlgorithmConfigurationServiceNameForAlgorithm($algorithmConfig);

            $algorithmDefinition = $this->definitionFactory->createDefinition(
                AlgorithmConfiguration::class,
                [
                    $algorithmConfig,
                    $this->referenceFactory->createReference($algorithmConfig['decryption']['service']),
                    $this->referenceFactory->createReference($algorithmConfig['encryption']['service']),
                    $this->referenceFactory->createReference(
                        $this->serviceNameGenerator->getReplacementPatternServiceNameForAlgorithm($algorithmConfig)
                    ),
                ]
            );

            $algorithmDefinition->setFactory([
                $this->referenceFactory->createReference(ServiceNames::ALGORITHM_CONFIGURATION_FACTORY),
                'createAlgorithmConfiguration',
            ]);

            $algorithmDefinition->setPublic(false);

            $algorithmDefinitions[$serviceName] = $algorithmDefinition;
        }

        $container->addDefinitions($algorithmDefinitions);
    }
}
