<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Helper;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * QuestionAskerInterface.
 */
interface QuestionAskerInterface
{
    /**
     * Getter: input.
     *
     * @return InputInterface
     */
    public function getInput();

    /**
     * Setter: input.
     *
     * @param InputInterface $input
     */
    public function setInput(InputInterface $input);

    /**
     * Getter: output.
     *
     * @return OutputInterface
     */
    public function getOutput();

    /**
     * Setter: output.
     *
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output);

    /**
     * Getter: question.
     *
     * @return Question
     */
    public function getQuestion();

    /**
     * Setter: question.
     *
     * @param Question $question
     */
    public function setQuestion(Question $question);

    /**
     * Getter: questionHelper.
     *
     * @return QuestionHelper
     */
    public function getQuestionHelper();

    /**
     * Setter: questionHelper.
     *
     * @param QuestionHelper $questionHelper
     */
    public function setQuestionHelper(QuestionHelper $questionHelper);

    /**
     * Ask question.
     *
     * @return mixed
     */
    public function askQuestion();
}
