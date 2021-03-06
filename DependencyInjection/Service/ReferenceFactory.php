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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * ReferenceFactory.
 */
class ReferenceFactory implements ReferenceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createReference($id, $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)
    {
        return new Reference($id, $invalidBehavior);
    }
}
