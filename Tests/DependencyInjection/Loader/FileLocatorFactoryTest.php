<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Loader;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Loader\FileLocatorFactory;
use Symfony\Component\Config\FileLocator;

class FileLocatorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileLocatorFactory
     */
    private $factory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->factory = new FileLocatorFactory();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->factory = null;
    }

    public function testCreateFileLocatorSuccessEmpty()
    {
        $fileLocator = $this->factory->createFileLocator();

        $this->assertInstanceOf(FileLocator::class, $fileLocator);
    }

    /**
     * @param array|string $paths
     *
     * @dataProvider providePathsData
     */
    public function testCreateFileLocatorSuccessNotEmpty($paths)
    {
        $fileLocator = $this->factory->createFileLocator($paths);

        $this->assertInstanceOf(FileLocator::class, $fileLocator);
    }

    /**
     * Data provider.
     */
    public function providePathsData()
    {
        return [
            'string' => [
                'path1',
            ],
            'array' => [
                [
                    'path1',
                    'path2',
                ],
            ],
        ];
    }
}
