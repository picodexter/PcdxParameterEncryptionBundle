<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Renderer;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Renderer\EncryptRenderer;

class EncryptRendererTest extends TestCase
{
    /**
     * @var EncryptRenderer
     */
    private $renderer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->renderer = new EncryptRenderer();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->renderer = null;
    }

    public function testGetMessageForGeneratedKeySuccess()
    {
        $this->assertNotEmptyString($this->renderer->getMessageForGeneratedKey());
    }

    public function testGetMessageForResultSuccess()
    {
        $this->assertNotEmptyString($this->renderer->getMessageForResult());
    }

    public function testGetMessageForStaticKeySuccess()
    {
        $this->assertNotEmptyString($this->renderer->getMessageForStaticKey());
    }

    /**
     * Assert that subject is a string and not empty.
     *
     * @param mixed $subject
     */
    private function assertNotEmptyString($subject)
    {
        $this->assertInternalType('string', $subject);
        $this->assertNotEmpty($subject);
    }
}
