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

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\DummyConfiguration;

class DummyConfigurationTest extends TestCase
{
    public function testDummy()
    {
        $dummy = new DummyConfiguration();

        $dummy->getConfigTreeBuilder();

        $this->assertTrue(true);
    }
}
