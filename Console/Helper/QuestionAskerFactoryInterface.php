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
 * QuestionAskerFactoryInterface.
 */
interface QuestionAskerFactoryInterface
{
    /**
     * Create question asker.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param Question        $question
     * @param QuestionHelper  $questionHelper
     *
     * @return QuestionAskerInterface
     */
    public function createQuestionAsker(
        InputInterface $input,
        OutputInterface $output,
        Question $question,
        QuestionHelper $questionHelper
    );
}
