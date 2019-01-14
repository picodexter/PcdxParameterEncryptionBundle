<?php

declare(strict_types=1);

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Encryption\Key;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyNotEmptyValidator;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyNotEmptyValidatorInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Encryption\EmptyKeyException;

class KeyNotEmptyValidatorTest extends TestCase
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

    public function testAssertKeyNotEmptyExceptionEmpty()
    {
        $this->expectException(EmptyKeyException::class);

        $this->validator->assertKeyNotEmpty('');
    }

    public function testAssertKeyNotEmptySuccess()
    {
        $this->validator->assertKeyNotEmpty('some_key');

        $this->assertTrue(true);
    }
}
