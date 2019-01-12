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

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;

class ServiceNamesTest extends TestCase
{
    public function testConstructorExceptionInstantiation()
    {
        $this->expectException(\BadMethodCallException::class);

        new ServiceNames();
    }
}
