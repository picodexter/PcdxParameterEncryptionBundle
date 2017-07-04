<?php

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
 * RewriterRegistry.
 */
class RewriterRegistry implements RewriterRegistryInterface
{
    /**
     * @var RewriterInterface[]
     */
    private $rewriters;

    /**
     * Constructor.
     *
     * @param RewriterInterface[] $rewriters
     */
    public function __construct(array $rewriters)
    {
        $this->setRewriters($rewriters);
    }

    /**
     * @inheritDoc
     */
    public function getRewriters()
    {
        return $this->rewriters;
    }

    /**
     * @inheritDoc
     */
    public function setRewriters($rewriters)
    {
        $validRewriters = array_filter($rewriters, function ($rewriter) {
            return ($rewriter instanceof RewriterInterface);
        });

        $this->rewriters = $validRewriters;
    }
}
