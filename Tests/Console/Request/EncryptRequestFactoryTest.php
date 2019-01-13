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

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Request;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequestFactory;

class EncryptRequestFactoryTest extends TestCase
{
    public function testCreateEncryptRequestSuccess()
    {
        $factory = new EncryptRequestFactory();

        $request = $factory->createEncryptRequest(
            'algo_01',
            'secret key',
            true,
            $this->createQuestionAskerInterfaceMock(),
            'plaintext'
        );

        $this->assertInstanceOf(EncryptRequest::class, $request);
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
