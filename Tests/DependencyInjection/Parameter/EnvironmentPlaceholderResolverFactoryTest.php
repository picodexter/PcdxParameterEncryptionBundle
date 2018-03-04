<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Parameter;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\EnvironmentPlaceholderResolver;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\EnvironmentPlaceholderResolverFactory;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\EnvironmentPlaceholderResolverInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Parameter\LegacyEnvironmentPlaceholderResolver;
use stdClass;

class EnvironmentPlaceholderResolverFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $classNameToCheck
     * @param string $expClass
     *
     * @dataProvider provideCreateResolverSuccessData
     */
    public function testCreateResolverSuccess($classNameToCheck, $expClass)
    {
        $resolver = EnvironmentPlaceholderResolverFactory::createResolver($classNameToCheck);

        $this->assertInstanceOf(EnvironmentPlaceholderResolverInterface::class, $resolver);
        $this->assertInstanceOf($expClass, $resolver);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideCreateResolverSuccessData()
    {
        return [
            'class exists - return proper resolver' => [
                stdClass::class,
                EnvironmentPlaceholderResolver::class,
            ],
            'class does not exist - return legacy resolver' => [
                'NonExistentClass',
                LegacyEnvironmentPlaceholderResolver::class,
            ],
        ];
    }
}
