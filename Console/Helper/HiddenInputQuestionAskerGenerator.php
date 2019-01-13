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

use Picodexter\ParameterEncryptionBundle\Console\Question\QuestionFactoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * HiddenInputQuestionAskerGenerator.
 */
class HiddenInputQuestionAskerGenerator implements HiddenInputQuestionAskerGeneratorInterface
{
    /**
     * @var QuestionAskerGeneratorInterface
     */
    private $questionAskerGenerator;

    /**
     * @var QuestionFactoryInterface
     */
    private $questionFactory;

    /**
     * Constructor.
     *
     * @param QuestionAskerGeneratorInterface $askerGenerator
     * @param QuestionFactoryInterface        $questionFactory
     */
    public function __construct(
        QuestionAskerGeneratorInterface $askerGenerator,
        QuestionFactoryInterface $questionFactory
    ) {
        $this->questionAskerGenerator = $askerGenerator;
        $this->questionFactory = $questionFactory;
    }

    /**
     * @inheritDoc
     */
    public function generateHiddenInputQuestionAsker(
        $questionText,
        InputInterface $input,
        OutputInterface $output,
        $hiddenFallback = true
    ) {
        $hiddenFallback = (bool) $hiddenFallback;

        $question = $this->questionFactory->createQuestion($questionText);
        $question->setHidden(true);
        $question->setHiddenFallback($hiddenFallback);

        return $this->questionAskerGenerator->createQuestionAskerForQuestion($question, $input, $output);
    }
}
