<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Question;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Question\QuestionFactory;
use Symfony\Component\Console\Question\Question;

class QuestionFactoryTest extends TestCase
{
    /**
     * @var QuestionFactory
     */
    private $factory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->factory = new QuestionFactory();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->factory = null;
    }

    public function testCreateQuestionSuccessNoDefault()
    {
        $questionText = 'Some question';

        $question = $this->factory->createQuestion($questionText);

        $this->assertInstanceOf(Question::class, $question);
        $this->assertSame($questionText, $question->getQuestion());
        $this->assertNull($question->getDefault());
    }

    public function testCreateQuestionSuccessWithDefault()
    {
        $questionText = 'Some question';
        $defaultValue = 'some default value';

        $question = $this->factory->createQuestion($questionText, $defaultValue);

        $this->assertInstanceOf(Question::class, $question);
        $this->assertSame($questionText, $question->getQuestion());
        $this->assertSame($defaultValue, $question->getDefault());
    }
}
