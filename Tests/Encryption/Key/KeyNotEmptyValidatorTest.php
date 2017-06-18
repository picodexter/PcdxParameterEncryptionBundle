<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Key;

use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyNotEmptyValidator;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyNotEmptyValidatorInterface;

class KeyNotEmptyValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyNotEmptyValidatorInterface
     */
    private $validator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->validator = new KeyNotEmptyValidator();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->validator = null;
    }

    /**
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException
     */
    public function testAssertKeyNotEmptyExceptionEmpty()
    {
        $this->validator->assertKeyNotEmpty('');
    }

    public function testAssertKeyNotEmptySuccess()
    {
        $this->validator->assertKeyNotEmpty('some_key');
    }
}
