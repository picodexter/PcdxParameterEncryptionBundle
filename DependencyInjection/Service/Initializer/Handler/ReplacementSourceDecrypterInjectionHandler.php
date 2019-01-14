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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidatorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ReplacementSourceDecrypterInjectionHandler.
 */
class ReplacementSourceDecrypterInjectionHandler implements ReplacementSourceDecrypterInjectionHandlerInterface
{
    /**
     * @var BundleConfigurationValidatorInterface
     */
    private $bundleConfigValidator;

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
     * @param ReferenceFactoryInterface             $referenceFactory
     * @param ServiceNameGeneratorInterface         $serviceNameGenerator
     */
    public function __construct(
        BundleConfigurationValidatorInterface $configValidator,
        ReferenceFactoryInterface $referenceFactory,
        ServiceNameGeneratorInterface $serviceNameGenerator
    ) {
        $this->bundleConfigValidator = $configValidator;
        $this->referenceFactory = $referenceFactory;
        $this->serviceNameGenerator = $serviceNameGenerator;
    }

    /**
     * @inheritDoc
     */
    public function injectReplacementSourceDecryptersIntoFetcher(array $bundleConfig, ContainerBuilder $container)
    {
        $this->bundleConfigValidator->assertValidBundleConfiguration($bundleConfig);

        $references = [];

        foreach ($bundleConfig['algorithms'] as $algorithmConfig) {
            $serviceName = $this->serviceNameGenerator
                ->getReplacementSourceDecrypterServiceNameForAlgorithm($algorithmConfig);

            $references[] = $this->referenceFactory->createReference($serviceName);
        }

        $fetcherDefinition = $container->getDefinition(ServiceNames::PARAMETER_REPLACEMENT_FETCHER);

        $fetcherDefinition->replaceArgument(0, $references);
    }
}
