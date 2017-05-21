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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * QuestionAskerGenerator.
 */
class QuestionAskerGenerator implements QuestionAskerGeneratorInterface
{
    /**
     * @var QuestionAskerFactoryInterface
     */
    private $questionAskerFactory;

    /**
     * @var QuestionHelperFactoryInterface
     */
    private $questionHelperFactory;

    /**
     * Constructor.
     *
     * @param QuestionAskerFactoryInterface  $questionAskerFactory
     * @param QuestionHelperFactoryInterface $helperFactory
     */
    public function __construct(
        QuestionAskerFactoryInterface $questionAskerFactory,
        QuestionHelperFactoryInterface $helperFactory
    ) {
        $this->questionAskerFactory = $questionAskerFactory;
        $this->questionHelperFactory = $helperFactory;
    }

    /**
     * @inheritDoc
     */
    public function createQuestionAskerForQuestion(Question $question, InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->questionHelperFactory->createQuestionHelper();

        return $this->questionAskerFactory->createQuestionAsker(
            $input,
            $output,
            $question,
            $questionHelper
        );
    }
}
