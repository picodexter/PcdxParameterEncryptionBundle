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
 * QuestionAskerGeneratorInterface.
 */
interface QuestionAskerGeneratorInterface
{
    /**
     * Generate question asker.
     *
     * @param Question        $question
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return QuestionAskerInterface
     */
    public function createQuestionAskerForQuestion(Question $question, InputInterface $input, OutputInterface $output);
}
