<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementPatternInjectionHandlerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementPatternRegistrationHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ReplacementPatternInitializer.
 */
class ReplacementPatternInitializer implements ReplacementPatternInitializerInterface
{
    /**
     * @var ReplacementPatternInjectionHandlerInterface
     */
    private $injectionHandler;

    /**
     * @var ReplacementPatternRegistrationHandlerInterface
     */
    private $registrationHandler;

    /**
     * Constructor.
     *
     * @param ReplacementPatternInjectionHandlerInterface    $injectionHandler
     * @param ReplacementPatternRegistrationHandlerInterface $registrationHandler
     */
    public function __construct(
        ReplacementPatternInjectionHandlerInterface $injectionHandler,
        ReplacementPatternRegistrationHandlerInterface $registrationHandler
    ) {
        $this->injectionHandler = $injectionHandler;
        $this->registrationHandler = $registrationHandler;
    }

    /**
     * @inheritDoc
     */
    public function initialize(array $bundleConfig, ContainerBuilder $container)
    {
        $this->registrationHandler->registerReplacementPatterns($bundleConfig, $container);
        $this->injectionHandler->injectReplacementPatternsIntoRegistry($bundleConfig, $container);
    }
}
