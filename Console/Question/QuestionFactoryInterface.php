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

namespace Picodexter\ParameterEncryptionBundle\Console\Question;

use Symfony\Component\Console\Question\Question;

/**
 * QuestionFactoryInterface.
 */
interface QuestionFactoryInterface
{
    /**
     * Create question.
     *
     * @param string $question The question to ask to the user
     * @param mixed  $default  The default answer to return if the user enters nothing
     *
     * @return Question
     */
    public function createQuestion($question, $default = null);
}
