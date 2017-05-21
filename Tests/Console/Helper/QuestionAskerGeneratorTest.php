<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Helper;

use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAsker;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerFactoryInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerGenerator;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionHelperFactoryInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class QuestionAskerGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QuestionAskerGenerator
     */
    private $generator;

    /**
     * @var QuestionAskerFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $questionAskerFactory;

    /**
     * @var QuestionHelperFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $questionHelperFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->questionAskerFactory = $this->createQuestionAskerFactoryInterfaceMock();
        $this->questionHelperFactory = $this->createQuestionHelperFactoryInterfaceMock();

        $this->generator = new QuestionAskerGenerator($this->questionAskerFactory, $this->questionHelperFactory);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->generator = null;
        $this->questionHelperFactory = null;
        $this->questionAskerFactory = null;
    }

    public function testCreateQuestionAskerForQuestionSuccess()
    {
        $preparedAsker = $this->createQuestionAskerMock();

        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();
        $question = $this->createQuestionMock();
        $questionHelper = $this->createQuestionHelperMock();

        $this->questionHelperFactory->expects($this->once())
            ->method('createQuestionHelper')
            ->with()
            ->will($this->returnValue($questionHelper));

        $this->questionAskerFactory->expects($this->once())
            ->method('createQuestionAsker')
            ->with(
                $this->identicalTo($input),
                $this->identicalTo($output),
                $this->identicalTo($question),
                $this->identicalTo($questionHelper)
            )
            ->will($this->returnValue($preparedAsker));

        $asker = $this->generator->createQuestionAskerForQuestion($question, $input, $output);

        $this->assertSame($preparedAsker, $asker);
    }

    /**
     * Create mock for InputInterface.
     *
     * @return InputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createInputInterfaceMock()
    {
        return $this->getMockBuilder(InputInterface::class)->getMock();
    }

    /**
     * Create mock for OutputInterface.
     *
     * @return OutputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createOutputInterfaceMock()
    {
        return $this->getMockBuilder(OutputInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionAskerFactoryInterface.
     *
     * @return QuestionAskerFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionAskerFactoryInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionAsker.
     *
     * @return QuestionAsker|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionAskerMock()
    {
        return $this->getMockBuilder(QuestionAsker::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for QuestionHelperFactoryInterface.
     *
     * @return QuestionHelperFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionHelperFactoryInterfaceMock()
    {
        return $this->getMockBuilder(QuestionHelperFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionHelper.
     *
     * @return QuestionHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionHelperMock()
    {
        return $this->getMockBuilder(QuestionHelper::class)->getMock();
    }

    /**
     * Create mock for Question.
     *
     * @return Question|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionMock()
    {
        return $this->getMockBuilder(Question::class)->disableOriginalConstructor()->getMock();
    }
}
