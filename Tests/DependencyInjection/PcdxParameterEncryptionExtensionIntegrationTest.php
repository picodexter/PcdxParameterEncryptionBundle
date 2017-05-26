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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\PcdxParameterEncryptionExtension;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class PcdxParameterEncryptionExtensionIntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadInternalSuccessServices()
    {
        $mergedConfig = [
            'algorithms' => [
                [
                    'id' => 'dummy_algo',
                    'pattern' => [
                        'type' => 'value_prefix',
                        'arguments' => [],
                    ],
                    'encryption' => [
                        'service' => 'encrypter_service',
                        'key' => null,
                    ],
                    'decryption' => [
                        'service' => 'decrypter_service',
                        'key' => null,
                    ],
                ],
            ],
        ];

        $container = new ContainerBuilder();

        $extension = new PcdxParameterEncryptionExtension();

        $extension->loadInternal($mergedConfig, $container);

        $service = $container->getDefinition(ServiceNames::PARAMETER_REPLACER);

        $this->assertInstanceOf(Definition::class, $service);
    }
}
