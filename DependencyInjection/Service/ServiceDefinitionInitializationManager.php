<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\AlgorithmInitializerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\ReplacementPatternInitializerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\ReplacementSourceDecrypterInitializerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ServiceDefinitionInitializationManager.
 */
class ServiceDefinitionInitializationManager implements ServiceDefinitionInitializationManagerInterface
{
    /**
     * @var AlgorithmInitializerInterface
     */
    private $algorithmInitializer;

    /**
     * @var ReplacementPatternInitializerInterface
     */
    private $replacementPatternInitializer;

    /**
     * @var ReplacementSourceDecrypterInitializerInterface
     */
    private $replacementSourceDecrypterInitializer;

    /**
     * Constructor.
     *
     * @param AlgorithmInitializerInterface                  $algorithmInitializer
     * @param ReplacementPatternInitializerInterface         $patternInitializer
     * @param ReplacementSourceDecrypterInitializerInterface $decrypterInitializer
     */
    public function __construct(
        AlgorithmInitializerInterface $algorithmInitializer,
        ReplacementPatternInitializerInterface $patternInitializer,
        ReplacementSourceDecrypterInitializerInterface $decrypterInitializer
    ) {
        $this->algorithmInitializer = $algorithmInitializer;
        $this->replacementPatternInitializer = $patternInitializer;
        $this->replacementSourceDecrypterInitializer = $decrypterInitializer;
    }

    /**
     * @inheritDoc
     */
    public function initializeServiceDefinitions(array $bundleConfig, ContainerBuilder $container)
    {
        $this->replacementPatternInitializer->initialize($bundleConfig, $container);
        $this->algorithmInitializer->initialize($bundleConfig, $container);
        $this->replacementSourceDecrypterInitializer->initialize($bundleConfig, $container);
    }
}
