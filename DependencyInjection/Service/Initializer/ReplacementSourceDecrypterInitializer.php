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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementSourceDecrypterInjectionHandlerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementSourceDecrypterRegistrationHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ReplacementSourceDecrypterInitializer.
 */
class ReplacementSourceDecrypterInitializer implements ReplacementSourceDecrypterInitializerInterface
{
    /**
     * @var ReplacementSourceDecrypterInjectionHandlerInterface
     */
    private $injectionHandler;

    /**
     * @var ReplacementSourceDecrypterRegistrationHandlerInterface
     */
    private $registrationHandler;

    /**
     * Constructor.
     *
     * @param ReplacementSourceDecrypterInjectionHandlerInterface    $injectionHandler
     * @param ReplacementSourceDecrypterRegistrationHandlerInterface $registrationHandler
     */
    public function __construct(
        ReplacementSourceDecrypterInjectionHandlerInterface $injectionHandler,
        ReplacementSourceDecrypterRegistrationHandlerInterface $registrationHandler
    ) {
        $this->injectionHandler = $injectionHandler;
        $this->registrationHandler = $registrationHandler;
    }

    /**
     * @inheritDoc
     */
    public function initialize(array $bundleConfig, ContainerBuilder $container)
    {
        $this->registrationHandler->registerReplacementSourceDecrypters($bundleConfig, $container);
        $this->injectionHandler->injectReplacementSourceDecryptersIntoFetcher($bundleConfig, $container);
    }
}
