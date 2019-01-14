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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\Service;

use Picodexter\ParameterEncryptionBundle\Exception\DependencyInjection\UnknownClassException;

/**
 * CryptoClassDetectorInterface.
 */
interface CryptoClassDetectorInterface
{
    /**
     * Check if the given class implements a decrypter.
     *
     * @param string $className
     *
     * @throws UnknownClassException
     *
     * @return bool
     */
    public function isDecrypterClass($className);

    /**
     * Check if the given class implements an encrypter.
     *
     * @param string $className
     *
     * @throws UnknownClassException
     *
     * @return bool
     */
    public function isEncrypterClass($className);
}
