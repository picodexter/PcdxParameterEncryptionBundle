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

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Helper;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerFactory;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class QuestionAskerFactoryTest extends TestCase
{
    public function testCreateQuestionAskerSuccess()
    {
        $factory = new QuestionAskerFactory();

        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();
        $question = $this->createQuestionMock();
        $questionHelper = $this->createQuestionHelperMock();

        $asker = $factory->createQuestionAsker($input, $output, $question, $questionHelper);

        $this->assertInstanceOf(QuestionAskerInterface::class, $asker);
    }

    /**
     * Create mock for InputInterface.
     *
     * @return InputInterface|MockObject
     */
    private function createInputInterfaceMock()
    {
        return $this->getMockBuilder(InputInterface::class)->getMock();
    }

    /**
     * Create mock for OutputInterface.
     *
     * @return OutputInterface|MockObject
     */
    private function createOutputInterfaceMock()
    {
        return $this->getMockBuilder(OutputInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionHelper.
     *
     * @return QuestionHelper|MockObject
     */
    private function createQuestionHelperMock()
    {
        return $this->getMockBuilder(QuestionHelper::class)->getMock();
    }

    /**
     * Create mock for Question.
     *
     * @return Question|MockObject
     */
    private function createQuestionMock()
    {
        return $this->getMockBuilder(Question::class)->disableOriginalConstructor()->getMock();
    }
}
