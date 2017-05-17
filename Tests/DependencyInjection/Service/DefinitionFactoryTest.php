<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactory;
use Symfony\Component\DependencyInjection\Definition;

class DefinitionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateDefinitionSuccess()
    {
        $factory = new DefinitionFactory();

        $definition = $factory->createDefinition();

        $this->assertInstanceOf(Definition::class, $definition);
    }
}
