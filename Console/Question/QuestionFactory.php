<?php

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
 * QuestionFactory.
 */
class QuestionFactory implements QuestionFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createQuestion($question, $default = null)
    {
        return new Question($question, $default);
    }
}
