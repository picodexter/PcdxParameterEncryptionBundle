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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * HiddenInputQuestionAskerGeneratorInterface.
 */
interface HiddenInputQuestionAskerGeneratorInterface
{
    /**
     * Generate question asker with hidden local echo for user input.
     *
     * @param string          $questionText
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param bool            $hiddenFallback
     *
     * @return QuestionAskerInterface
     */
    public function generateHiddenInputQuestionAsker(
        $questionText,
        InputInterface $input,
        OutputInterface $output,
        $hiddenFallback = true
    );
}
