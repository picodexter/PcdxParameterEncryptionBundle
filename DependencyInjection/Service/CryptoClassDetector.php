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

use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection\UnknownClassException;
use ReflectionClass;
use ReflectionException;

/**
 * CryptoClassDetector.
 */
class CryptoClassDetector implements CryptoClassDetectorInterface
{
    /**
     * @inheritDoc
     */
    public function isDecrypterClass($className)
    {
        $reflectionClass = $this->getReflectionClass($className);

        return \in_array(DecrypterInterface::class, $reflectionClass->getInterfaceNames(), true);
    }

    /**
     * @inheritDoc
     */
    public function isEncrypterClass($className)
    {
        $reflectionClass = $this->getReflectionClass($className);

        return \in_array(EncrypterInterface::class, $reflectionClass->getInterfaceNames(), true);
    }

    /**
     * Get reflection class.
     *
     * @param string $className
     *
     * @throws UnknownClassException
     *
     * @return ReflectionClass
     */
    private function getReflectionClass($className)
    {
        try {
            return new ReflectionClass($className);
        } catch (ReflectionException $e) {
            throw new UnknownClassException($className);
        }
    }
}
