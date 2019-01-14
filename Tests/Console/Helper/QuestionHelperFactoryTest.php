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

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Helper;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionHelperFactory;
use Symfony\Component\Console\Helper\QuestionHelper;

class QuestionHelperFactoryTest extends TestCase
{
    public function testCreateQuestionHelperSuccess()
    {
        $factory = new QuestionHelperFactory();

        $helper = $factory->createQuestionHelper();

        $this->assertInstanceOf(QuestionHelper::class, $helper);
    }
}
