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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition\Rewriter\RewriterRegistry;
use stdClass;

class RewriterRegistryTest extends TestCase
{
    /**
     * @param array $rewriters
     * @param int   $expectedCount
     *
     * @dataProvider provideSetRewritersData
     */
    public function testConstructorSuccess(array $rewriters, $expectedCount)
    {
        $registry = new RewriterRegistry($rewriters);

        $this->assertCount($expectedCount, $registry->getRewriters());
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideSetRewritersData()
    {
        return [
            'one valid rewriter' => [
                [
                    $this->createRewriterInterfaceMock(),
                ],
                1,
            ],
            '3 different rewriters' => [
                [
                    $this->createRewriterInterfaceMock(),
                    $this->createRewriterInterfaceMock(),
                    $this->createRewriterInterfaceMock(),
                ],
                3,
            ],
            'no valid rewriters' => [
                [
                    1,
                    false,
                    true,
                    null,
                    1.23,
                    'a string',
                    new stdClass(),
                ],
                0,
            ],
            'mixed' => [
                [
                    1,
                    $this->createRewriterInterfaceMock(),
                    'a string',
                    false,
                ],
                1,
            ],
        ];
    }

    /**
     * @param array $rewriters
     * @param int   $expectedCount
     *
     * @dataProvider provideSetRewritersData
     */
    public function testGetSetRewritersSuccess(array $rewriters, $expectedCount)
    {
        $registry = new RewriterRegistry([]);

        $this->assertCount(0, $registry->getRewriters());

        $registry->setRewriters($rewriters);

        $this->assertCount($expectedCount, $registry->getRewriters());
    }

    /**
     * Create mock for RewriterInterface.
     *
     * @return RewriterInterface|MockObject
     */
    private function createRewriterInterfaceMock()
    {
        return $this->getMockBuilder(RewriterInterface::class)->getMock();
    }
}
