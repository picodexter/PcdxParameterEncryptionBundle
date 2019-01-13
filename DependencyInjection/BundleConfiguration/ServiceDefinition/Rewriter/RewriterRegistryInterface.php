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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter;

/**
 * RewriterRegistryInterface.
 */
interface RewriterRegistryInterface
{
    /**
     * Getter: rewriters.
     *
     * @return RewriterInterface[]
     */
    public function getRewriters();

    /**
     * Setter: rewriters.
     *
     * @param RewriterInterface[] $rewriters
     */
    public function setRewriters($rewriters);
}
