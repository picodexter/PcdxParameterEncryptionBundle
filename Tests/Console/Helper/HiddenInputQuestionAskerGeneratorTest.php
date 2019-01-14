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
use Picodexter\ParameterEncryptionBundle\Console\Helper\HiddenInputQuestionAskerGenerator;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Question\QuestionFactoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class HiddenInputQuestionAskerGeneratorTest extends TestCase
{
    /**
     * @var HiddenInputQuestionAskerGenerator
     */
    private $generator;

    /**
     * @var QuestionAskerGeneratorInterface|MockObject
     */
    private $questionAskerGenerator;

    /**
     * @var QuestionFactoryInterface|MockObject
     */
    private $questionFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->questionAskerGenerator = $this->createQuestionAskerGeneratorInterfaceMock();
        $this->questionFactory = $this->createQuestionFactoryInterfaceMock();

        $this->generator = new HiddenInputQuestionAskerGenerator($this->questionAskerGenerator, $this->questionFactory);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->generator = null;
        $this->questionFactory = null;
        $this->questionAskerGenerator = null;
    }

    /**
     * @param mixed $hiddenFallback
     * @param bool  $expectedFallback
     *
     * @dataProvider provideHiddenFallbackData
     */
    public function testGenerateHiddenInputQuestionAskerSuccessHiddenFallbackSpecified(
        $hiddenFallback,
        $expectedFallback
    ) {
        $questionText = 'This is a question?';

        $question = $this->createQuestionMock();
        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();
        $preparedAsker = $this->createQuestionAskerInterfaceMock();

        $this->setUpQuestionFactoryCreateQuestion($questionText, $question);

        $this->setUpQuestionSetHiddenFallback($question, $expectedFallback);

        $this->setUpQuestionAskerGeneratorCreateQuestionAskerForQuestion($question, $input, $output, $preparedAsker);

        $questionAsker = $this->generator
            ->generateHiddenInputQuestionAsker($questionText, $input, $output, $hiddenFallback);

        $this->assertSame($preparedAsker, $questionAsker);
    }

    /**
     * Data provider.
     */
    public function provideHiddenFallbackData()
    {
        return [
            'true' => [
                true,
                true,
            ],
            'false' => [
                false,
                false,
            ],
            'string = 123abc' => [
                '123abc',
                true,
            ],
        ];
    }

    public function testGenerateHiddenInputQuestionAskerSuccessHiddenFallbackUnspecified()
    {
        $questionText = 'This is a question?';

        $question = $this->createQuestionMock();
        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();
        $preparedAsker = $this->createQuestionAskerInterfaceMock();

        $this->setUpQuestionFactoryCreateQuestion($questionText, $question);

        $this->setUpQuestionSetHiddenFallback($question, true);

        $this->setUpQuestionAskerGeneratorCreateQuestionAskerForQuestion($question, $input, $output, $preparedAsker);

        $questionAsker = $this->generator->generateHiddenInputQuestionAsker($questionText, $input, $output);

        $this->assertSame($preparedAsker, $questionAsker);
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
     * Create mock for QuestionAskerGeneratorInterface.
     *
     * @return QuestionAskerGeneratorInterface|MockObject
     */
    private function createQuestionAskerGeneratorInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerGeneratorInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionAskerInterface.
     *
     * @return QuestionAskerInterface|MockObject
     */
    private function createQuestionAskerInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionFactoryInterface.
     *
     * @return QuestionFactoryInterface|MockObject
     */
    private function createQuestionFactoryInterfaceMock()
    {
        return $this->getMockBuilder(QuestionFactoryInterface::class)->getMock();
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

    /**
     * Set up question asker generator: create question asker for question.
     *
     * @param Question               $question
     * @param InputInterface         $input
     * @param OutputInterface        $output
     * @param QuestionAskerInterface $preparedAsker
     */
    private function setUpQuestionAskerGeneratorCreateQuestionAskerForQuestion(
        Question $question,
        InputInterface $input,
        OutputInterface $output,
        QuestionAskerInterface $preparedAsker
    ) {
        $this->questionAskerGenerator->expects($this->once())
            ->method('createQuestionAskerForQuestion')
            ->with(
                $this->identicalTo($question),
                $this->identicalTo($input),
                $this->identicalTo($output)
            )
            ->will($this->returnValue($preparedAsker));
    }

    /**
     * Set up question factory: create question.
     *
     * @param string   $questionText
     * @param Question $preparedQuestion
     */
    private function setUpQuestionFactoryCreateQuestion($questionText, Question $preparedQuestion)
    {
        $this->questionFactory->expects($this->once())
            ->method('createQuestion')
            ->with($this->identicalTo($questionText))
            ->will($this->returnValue($preparedQuestion));
    }

    /**
     * Set up question: set hidden fallback.
     *
     * @param Question|MockObject $question
     * @param bool                $expectedFallback
     */
    private function setUpQuestionSetHiddenFallback(Question $question, $expectedFallback)
    {
        $question->expects($this->once())
            ->method('setHiddenFallback')
            ->with($this->identicalTo($expectedFallback));
    }
}
