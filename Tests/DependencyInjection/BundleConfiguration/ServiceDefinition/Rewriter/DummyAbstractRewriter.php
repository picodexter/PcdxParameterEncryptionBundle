<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\AbstractRewriter;
use Symfony\Component\DependencyInjection\Definition;

/**
 * DummyAbstractRewriter.
 */
class DummyAbstractRewriter extends AbstractRewriter
{
    /**
     * @inheritDoc
     */
    public function applies($serviceId, Definition $definition, array $extensionConfig)
    {
    }

    /**
     * @inheritDoc
     */
    public function processServiceDefinition($serviceId, Definition $definition, array $extensionConfig)
    {
    }
}
