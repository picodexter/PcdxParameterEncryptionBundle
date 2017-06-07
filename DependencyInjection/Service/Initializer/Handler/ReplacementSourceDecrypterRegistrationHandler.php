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
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Source\DecrypterReplacementSource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ReplacementSourceDecrypterRegistrationHandler.
 */
class ReplacementSourceDecrypterRegistrationHandler implements ReplacementSourceDecrypterRegistrationHandlerInterface
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
    public function registerReplacementSourceDecrypters(array $bundleConfig, ContainerBuilder $container)
    {
        $this->bundleConfigValidator->assertValidBundleConfiguration($bundleConfig);

        $definitions = [];

        foreach ($bundleConfig['algorithms'] as $algorithmConfig) {
            $definition = $this->definitionFactory->createDefinition(
                DecrypterReplacementSource::class,
                [
                    $this->referenceFactory->createReference($algorithmConfig['decryption']['service']),
                    $this->referenceFactory->createReference(
                        $this->serviceNameGenerator->getReplacementPatternServiceNameForAlgorithm($algorithmConfig)
                    ),
                    $algorithmConfig['decryption']['key']['value'],
                ]
            );

            $definition->setPublic(false);

            $serviceName = $this->serviceNameGenerator
                ->getReplacementSourceDecrypterServiceNameForAlgorithm($algorithmConfig);

            $definitions[$serviceName] = $definition;
        }

        $container->addDefinitions($definitions);
    }
}
