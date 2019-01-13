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
 * ReferenceFactoryInterface.
 */
interface ReferenceFactoryInterface
{
    /**
     * Create reference for a Symfony service.
     *
     * @param string $id              The service identifier
     * @param int    $invalidBehavior The behavior when the service does not exist
     *
     * @return Reference
     */
    public function createReference($id, $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE);
}
