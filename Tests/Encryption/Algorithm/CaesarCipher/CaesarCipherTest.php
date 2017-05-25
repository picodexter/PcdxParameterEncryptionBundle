<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Algorithm\CaesarCipher;

use Picodexter\ParameterEncryptionBundle\Encryption\Algorithm\CaesarCipher\CaesarCipher;

class CaesarCipherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CaesarCipher
     */
    private $cipher;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->cipher = new CaesarCipher();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->cipher = null;
    }

    /**
     * @param string $inputText
     * @param int    $rotationAmount
     * @param string $expectedOutputText
     *
     * @dataProvider provideApplySuccessData
     */
    public function testApplySuccess($inputText, $rotationAmount, $expectedOutputText)
    {
        $outputText = $this->cipher->apply($inputText, $rotationAmount);

        $this->assertSame($expectedOutputText, $outputText);
    }

    /**
     * Data provider.
     */
    public function provideApplySuccessData()
    {
        return [
            'complete alphabet, rotation = 13' => [
                'abcdefghijklmnopqrstuvwxyz',
                13,
                'nopqrstuvwxyzabcdefghijklm',
            ],
            'complete alphabet, rotation = -13' => [
                'abcdefghijklmnopqrstuvwxyz',
                13,
                'nopqrstuvwxyzabcdefghijklm',
            ],
            'alphabet with upper case, rotation = 13' => [
                'abcDEFGhijklMNOPQrstUvWxyZ',
                13,
                'nopQRSTuvwxyZABCDefgHiJklM',
            ],
            'no alphabet characters, rotation = 13' => [
                '.,-àäü @!€',
                13,
                '.,-àäü @!€',
            ],
            'mixed, rotation = 10' => [
                'abcdefz áù words 😃',
                10,
                'klmnopj áù gybnc 😃',
            ],
            'non-numeric rotation' => [
                'abcdef',
                'notanint',
                'abcdef',
            ],
            'non-numeric rotation cast to int' => [
                'abcdef',
                '3notanint',
                'defghi',
            ],
            'rotation = 0' => [
                'abcdef',
                0,
                'abcdef',
            ],
            'rotation > alphabet size' => [
                'abcdef',
                100,
                'wxyzab',
            ],
            'rotation < 0' => [
                'abcdef',
                -100,
                'efghij',
            ],
            'empty input text' => [
                '',
                13,
                '',
            ],
        ];
    }
}
