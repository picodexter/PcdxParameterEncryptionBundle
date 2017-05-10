<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\ContainerBuilderFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerBuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateContainerBuilderSuccess()
    {
        $containerBuilder = ContainerBuilderFactory::createContainerBuilder();

        $this->assertInstanceOf(ContainerBuilder::class, $containerBuilder);
    }
}