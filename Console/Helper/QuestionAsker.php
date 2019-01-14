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

namespace Picodexter\ParameterEncryptionBundle\Console\Helper;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * QuestionAsker.
 */
class QuestionAsker implements QuestionAskerInterface
{
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var Question
     */
    private $question;

    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * Constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param Question        $question
     * @param QuestionHelper  $questionHelper
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        Question $question,
        QuestionHelper $questionHelper
    ) {
        $this->input = $input;
        $this->output = $output;
        $this->question = $question;
        $this->questionHelper = $questionHelper;
    }

    /**
     * @inheritDoc
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @inheritDoc
     */
    public function setInput(InputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * @inheritDoc
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @inheritDoc
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @inheritDoc
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @inheritDoc
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
    }

    /**
     * @inheritDoc
     */
    public function getQuestionHelper()
    {
        return $this->questionHelper;
    }

    /**
     * @inheritDoc
     */
    public function setQuestionHelper(QuestionHelper $questionHelper)
    {
        $this->questionHelper = $questionHelper;
    }

    /**
     * @inheritDoc
     */
    public function askQuestion()
    {
        return $this->questionHelper->ask($this->input, $this->output, $this->question);
    }
}
