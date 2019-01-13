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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\CryptoClassDetectorInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\Decorator\KeyNotEmptyDecrypterDecorator;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\Decorator\KeyNotEmptyEncrypterDecorator;

/**
 * KeyNotEmptyDecoratorClassResolver.
 */
class KeyNotEmptyDecoratorClassResolver implements KeyNotEmptyDecoratorClassResolverInterface
{
    /**
     * @var CryptoClassDetectorInterface
     */
    private $cryptoClassDetector;

    /**
     * Constructor.
     *
     * @param CryptoClassDetectorInterface $cryptoClassDetector
     */
    public function __construct(CryptoClassDetectorInterface $cryptoClassDetector)
    {
        $this->cryptoClassDetector = $cryptoClassDetector;
    }

    /**
     * @inheritDoc
     */
    public function getDecoratorClassForDecoratedClass($serviceClass)
    {
        if ($this->cryptoClassDetector->isEncrypterClass($serviceClass)) {
            $decoratorClass = KeyNotEmptyEncrypterDecorator::class;
        } else {
            $decoratorClass = KeyNotEmptyDecrypterDecorator::class;
        }

        return $decoratorClass;
    }
}
