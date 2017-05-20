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

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidator;

class BundleConfigurationValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BundleConfigurationValidator
     */
    private $validator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->validator = new BundleConfigurationValidator();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->validator = null;
    }

    /**
     * @param array $bundleConfig
     *
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidBundleConfigurationException
     * @dataProvider provideInvalidBundleConfigData
     */
    public function testAssertValidBundleConfigurationExceptionInvalidConfig(array $bundleConfig)
    {
        $this->validator->assertValidBundleConfiguration($bundleConfig);
    }

    /**
     * Data provider.
     */
    public function provideInvalidBundleConfigData()
    {
        return [
            'empty' => [
                [],
            ],
            'no key "algorithms"' => [
                [
                    'foo' => 'bar',
                ],
            ],
            'value "algorithms" is not an array' => [
                [
                    'algorithms' => 'a string',
                ],
            ],
        ];
    }

    public function testAssertValidBundleConfigurationSuccess()
    {
        $this->validator->assertValidBundleConfiguration([
            'algorithms' => [],
        ]);

        $this->assertTrue(true);
    }
}
