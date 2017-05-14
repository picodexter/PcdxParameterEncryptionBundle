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

use Picodexter\ParameterEncryptionBundle\Configuration\Algorithm;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

class AlgorithmTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $id
     *
     * @dataProvider provideInvalidIdData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\InvalidAlgorithmIdException
     */
    public function testConstructorExceptionInvalidId($id)
    {
        $this->createAlgorithmWithId($id);
    }

    /**
     * Data provider.
     */
    public function provideInvalidIdData()
    {
        return [
            'invalid - contains space' => [
                'some id',
            ],
            'invalid - contains dash' => [
                'some-id',
            ],
            'invalid - ' => [
                '',
            ],
        ];
    }

    /**
     * @param string $id
     * @param string $expectedId
     *
     * @dataProvider provideValidIdData
     */
    public function testConstructorSuccess($id, $expectedId)
    {
        $algorithm = $this->createAlgorithmWithId($id);

        $this->assertSame($expectedId, $algorithm->getId());
    }

    /**
     * Data provider.
     */
    public function provideValidIdData()
    {
        return [
            'valid - lowercase letters' => [
                'abc',
                'abc',
            ],
            'valid - uppercase letters' => [
                'ABC',
                'abc',
            ],
            'valid - numbers' => [
                '123',
                '123',
            ],
            'valid - underscore' => [
                '_',
                '_',
            ],
            'valid - period' => [
                '.',
                '.',
            ],
            'valid - mixed' => [
                'abc_ABC.123',
                'abc_abc.123',
            ],
        ];
    }

    /**
     * @param string $id
     *
     * @dataProvider provideInvalidIdData
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\InvalidAlgorithmIdException
     */
    public function testSetIdExceptionInvalidId($id)
    {
        $this->createAlgorithmWithId($id);
    }

    /**
     * @param string $id
     * @param string $expectedId
     *
     * @dataProvider provideValidIdData
     */
    public function testSetIdSuccess($id, $expectedId)
    {
        $algorithm = $this->createAlgorithmWithId($id);

        $this->assertSame($expectedId, $algorithm->getId());
    }

    /**
     * Create Algorithm with ID.
     *
     * @param string $id
     * @return Algorithm
     */
    private function createAlgorithmWithId($id)
    {
        $decrypter = $this->createDecrypterInterfaceMock();
        $encrypter = $this->createEncrypterInterfaceMock();
        $replacementPattern = $this->createReplacementPatternInterfaceMock();

        return new Algorithm($id, $decrypter, $encrypter, '', $replacementPattern);
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
