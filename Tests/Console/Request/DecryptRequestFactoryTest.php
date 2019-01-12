<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Request;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequestFactory;

class DecryptRequestFactoryTest extends TestCase
{
    public function testCreateEncryptRequestSuccess()
    {
        $factory = new DecryptRequestFactory();

        $request = $factory->createDecryptRequest(
            'algo_01',
            $this->createQuestionAskerInterfaceMock(),
            'encrypted text',
            'secret key',
            true
        );

        $this->assertInstanceOf(DecryptRequest::class, $request);
    }

    /**
     * Create mock for QuestionAsker.
     *
     * @return QuestionAskerInterface|MockObject
     */
    private function createQuestionAskerInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerInterface::class)->disableOriginalConstructor()->getMock();
    }
}
