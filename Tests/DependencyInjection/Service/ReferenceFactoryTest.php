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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactory;
use Symfony\Component\DependencyInjection\Reference;

class ReferenceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateReferenceSuccess()
    {
        $factory = new ReferenceFactory();

        $reference = $factory->createReference('service_id');

        $this->assertInstanceOf(Reference::class, $reference);
    }
}
