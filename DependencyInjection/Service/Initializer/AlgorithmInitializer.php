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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\AlgorithmInjectionHandlerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\AlgorithmRegistrationHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * AlgorithmInitializer.
 */
class AlgorithmInitializer implements AlgorithmInitializerInterface
{
    /**
     * @var AlgorithmInjectionHandlerInterface
     */
    private $injectionHandler;

    /**
     * @var AlgorithmRegistrationHandlerInterface
     */
    private $registrationHandler;

    /**
     * Constructor.
     *
     * @param AlgorithmInjectionHandlerInterface    $injectionHandler
     * @param AlgorithmRegistrationHandlerInterface $registrationHandler
     */
    public function __construct(
        AlgorithmInjectionHandlerInterface $injectionHandler,
        AlgorithmRegistrationHandlerInterface $registrationHandler
    ) {
        $this->injectionHandler = $injectionHandler;
        $this->registrationHandler = $registrationHandler;
    }

    /**
     * @inheritDoc
     */
    public function initialize(array $bundleConfig, ContainerBuilder $container)
    {
        $this->registrationHandler->registerAlgorithms($bundleConfig, $container);
        $this->injectionHandler->injectAlgorithmsIntoConfiguration($bundleConfig, $container);
    }
}
