<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Configuration;

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainer;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

class AlgorithmConfigurationContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $algorithms
     *
     * @dataProvider provideDuplicateIdData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\DuplicateAlgorithmIdException
     */
    public function testConstructorExceptionDuplicateId(array $algorithms)
    {
        new AlgorithmConfigurationContainer($algorithms);
    }

    /**
     * Data provider.
     */
    public function provideDuplicateIdData()
    {
        return [
            '2 identical IDs - 2 items' => [
                [
                    $this->createAlgorithmConfigurationWithId('some_id'),
                    $this->createAlgorithmConfigurationWithId('some_id'),
                ],
            ],
            '3 identical IDs - 3 items' => [
                [
                    $this->createAlgorithmConfigurationWithId('some_id'),
                    $this->createAlgorithmConfigurationWithId('some_id'),
                    $this->createAlgorithmConfigurationWithId('some_id'),
                ],
            ],
            '2 identical IDs - 5 items' => [
                [
                    $this->createAlgorithmConfigurationWithId('first_algorithm'),
                    $this->createAlgorithmConfigurationWithId('some_id'),
                    $this->createAlgorithmConfigurationWithId('another_algorithm'),
                    $this->createAlgorithmConfigurationWithId('some_id'),
                    $this->createAlgorithmConfigurationWithId('algorithm5'),
                ],
            ],
        ];
    }

    /**
     * @param array $algorithms
     * @param int   $expectedCount
     *
     * @dataProvider provideUniqueIdData
     */
    public function testConstructorSuccess(array $algorithms, $expectedCount)
    {
        $algorithmConfig = new AlgorithmConfigurationContainer($algorithms);

        $this->assertCount($expectedCount, $algorithmConfig->getAlgorithmConfigurations());
    }

    /**
     * Data provider.
     */
    public function provideUniqueIdData()
    {
        return [
            'empty - empty input' => [
                [],
                0,
            ],
            'empty - not algorithms' => [
                [
                    true,
                    false,
                    1,
                    1.1,
                    'string',
                ],
                0,
            ],
            '1 algorithm' => [
                [
                    $this->createAlgorithmConfigurationWithId('foo'),
                ],
                1,
            ],
            'mixed - 2 algorithms and random data' => [
                [
                    1,
                    $this->createAlgorithmConfigurationWithId('foo'),
                    $this->createAlgorithmConfigurationWithId('bar'),
                    1.1,
                    'string',
                ],
                2,
            ],
        ];
    }

    /**
     * @param array $algorithms
     *
     * @dataProvider provideDuplicateIdData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\DuplicateAlgorithmIdException
     */
    public function testSetAlgorithmConfigurationsExceptionDuplicateId(array $algorithms)
    {
        $algorithmConfig = new AlgorithmConfigurationContainer([]);

        $algorithmConfig->setAlgorithmConfigurations($algorithms);
    }

    /**
     * @param array $algorithms
     * @param int   $expectedCount
     *
     * @dataProvider provideUniqueIdData
     */
    public function testSetAlgorithmConfigurationsSuccess(array $algorithms, $expectedCount)
    {
        $algorithmConfig = new AlgorithmConfigurationContainer([]);

        $algorithmConfig->setAlgorithmConfigurations($algorithms);

        $this->assertCount($expectedCount, $algorithmConfig->getAlgorithmConfigurations());
    }

    public function testGetSuccessFound()
    {
        $targetAlgorithm = $this->createAlgorithmConfigurationWithId('foo');

        $algorithmConfig = new AlgorithmConfigurationContainer([
            $targetAlgorithm,
            $this->createAlgorithmConfigurationWithId('bar'),
        ]);

        $result = $algorithmConfig->get('foo');

        $this->assertSame($targetAlgorithm, $result);
    }

    public function testGetSuccessNotFound()
    {
        $algorithmConfig = new AlgorithmConfigurationContainer([
            $this->createAlgorithmConfigurationWithId('foo'),
        ]);

        $result = $algorithmConfig->get('bar');

        $this->assertNull($result);
    }

    public function testHasSuccessFound()
    {
        $algorithmConfig = new AlgorithmConfigurationContainer([
            $this->createAlgorithmConfigurationWithId('foobar'),
        ]);

        $result = $algorithmConfig->has('foobar');

        $this->assertTrue($result);
    }

    public function testHasSuccessNotFound()
    {
        $algorithmConfig = new AlgorithmConfigurationContainer([
            $this->createAlgorithmConfigurationWithId('foobar'),
        ]);

        $result = $algorithmConfig->has('no_find');

        $this->assertFalse($result);
    }

    /**
     * Create algorithm with ID.
     *
     * @param string $id
     * @return AlgorithmConfiguration
     */
    private function createAlgorithmConfigurationWithId($id)
    {
        $decrypter = $this->createDecrypterInterfaceMock();
        $encrypter = $this->createEncrypterInterfaceMock();
        $replacementPattern = $this->createReplacementPatternInterfaceMock();

        return new AlgorithmConfiguration($id, $decrypter, $encrypter, null, $replacementPattern);
    }

    /**
     * Create mock for DecrypterInterface.
     *
     * @return DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDecrypterInterfaceMock()
    {
        return $this->getMockBuilder(DecrypterInterface::class)->getMock();
    }

    /**
     * Create mock for EncrypterInterface.
     *
     * @return EncrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createEncrypterInterfaceMock()
    {
        return $this->getMockBuilder(EncrypterInterface::class)->getMock();
    }

    /**
     * Create mock for ReplacementPatternInterface.
     *
     * @return ReplacementPatternInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReplacementPatternInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInterface::class)->getMock();
    }
}