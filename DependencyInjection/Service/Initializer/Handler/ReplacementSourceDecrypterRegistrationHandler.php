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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\EnvironmentPlaceholderResolverInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidatorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
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
     * @var EnvironmentPlaceholderResolverInterface
     */
    private $environmentPlaceholderResolver;

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
     * @param BundleConfigurationValidatorInterface   $bundleConfigValidator
     * @param DefinitionFactoryInterface              $definitionFactory
     * @param EnvironmentPlaceholderResolverInterface $environmentPlaceholderResolver
     * @param ReferenceFactoryInterface               $referenceFactory
     * @param ServiceNameGeneratorInterface           $serviceNameGenerator
     */
    public function __construct(
        BundleConfigurationValidatorInterface $bundleConfigValidator,
        DefinitionFactoryInterface $definitionFactory,
        EnvironmentPlaceholderResolverInterface $environmentPlaceholderResolver,
        ReferenceFactoryInterface $referenceFactory,
        ServiceNameGeneratorInterface $serviceNameGenerator
    ) {
        $this->bundleConfigValidator = $bundleConfigValidator;
        $this->definitionFactory = $definitionFactory;
        $this->environmentPlaceholderResolver = $environmentPlaceholderResolver;
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
            $decryptionKeyConfig = $this->environmentPlaceholderResolver->resolveEnvironmentPlaceholders(
                $algorithmConfig['decryption']['key'],
                $container
            );

            $decryptionKeyConfDef = $this->definitionFactory->createDefinition(
                KeyConfiguration::class,
                [$decryptionKeyConfig]
            );
            $decryptionKeyConfDef->setFactory([
                $this->referenceFactory->createReference(ServiceNames::KEY_CONFIGURATION_FACTORY),
                'createKeyConfiguration',
            ]);

            $definition = $this->definitionFactory->createDefinition(
                DecrypterReplacementSource::class,
                [
                    $this->referenceFactory->createReference($algorithmConfig['decryption']['service']),
                    $decryptionKeyConfDef,
                    $this->referenceFactory->createReference(ServiceNames::KEY_FETCHER),
                    $this->referenceFactory->createReference(
                        $this->serviceNameGenerator->getReplacementPatternServiceNameForAlgorithm($algorithmConfig)
                    ),
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
