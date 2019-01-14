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

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Dispatcher;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Dispatcher\DecryptDispatcher;
use Picodexter\ParameterEncryptionBundle\Console\Helper\HiddenInputQuestionAskerGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\DecryptProcessorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequestFactoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DecryptDispatcherTest extends TestCase
{
    /**
     * @var DecryptDispatcher
     */
    private $dispatcher;

    /**
     * @var DecryptProcessorInterface|MockObject
     */
    private $processor;

    /**
     * @var HiddenInputQuestionAskerGeneratorInterface|MockObject
     */
    private $questionAskerGenerator;

    /**
     * @var DecryptRequestFactoryInterface|MockObject
     */
    private $requestFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->processor = $this->createDecryptProcessorInterfaceMock();
        $this->questionAskerGenerator = $this->createHiddenInputQuestionAskerGeneratorInterfaceMock();
        $this->requestFactory = $this->createDecryptRequestFactoryInterfaceMock();

        $this->dispatcher = new DecryptDispatcher(
            $this->requestFactory,
            $this->processor,
            $this->questionAskerGenerator
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->dispatcher = null;
        $this->requestFactory = null;
        $this->questionAskerGenerator = null;
        $this->processor = null;
    }

    public function testDispatchToProcessorSuccess()
    {
        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();
        $request = $this->createDecryptRequestMock();
        $questionAsker = $this->createQuestionAskerInterfaceMock();

        $this->requestFactory->expects($this->once())
            ->method('createDecryptRequest')
            ->will($this->returnValue($request));

        $this->questionAskerGenerator->expects($this->once())
            ->method('generateHiddenInputQuestionAsker')
            ->will($this->returnValue($questionAsker));

        $this->processor->expects($this->once())
            ->method('renderDecryptOutput')
            ->with(
                $this->identicalTo($request),
                $this->identicalTo($output)
            );

        $this->dispatcher->dispatchToProcessor($input, $output);
    }

    /**
     * Create mock for DecryptProcessorInterface.
     *
     * @return DecryptProcessorInterface|MockObject
     */
    private function createDecryptProcessorInterfaceMock()
    {
        return $this->getMockBuilder(DecryptProcessorInterface::class)->getMock();
    }

    /**
     * Create mock for DecryptRequestFactoryInterface.
     *
     * @return DecryptRequestFactoryInterface|MockObject
     */
    private function createDecryptRequestFactoryInterfaceMock()
    {
        return $this->getMockBuilder(DecryptRequestFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for DecryptRequest.
     *
     * @return DecryptRequest|MockObject
     */
    private function createDecryptRequestMock()
    {
        return $this->getMockBuilder(DecryptRequest::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for HiddenInputQuestionAskerGeneratorInterface.
     *
     * @return HiddenInputQuestionAskerGeneratorInterface|MockObject
     */
    private function createHiddenInputQuestionAskerGeneratorInterfaceMock()
    {
        return $this->getMockBuilder(HiddenInputQuestionAskerGeneratorInterface::class)->getMock();
    }

    /**
     * Create mock for InputInterface.
     *
     * @return InputInterface|MockObject
     */
    private function createInputInterfaceMock()
    {
        return $this->getMockBuilder(InputInterface::class)->getMock();
    }

    /**
     * Create mock for OutputInterface.
     *
     * @return OutputInterface|MockObject
     */
    private function createOutputInterfaceMock()
    {
        return $this->getMockBuilder(OutputInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionAskerInterface.
     *
     * @return QuestionAskerInterface|MockObject
     */
    private function createQuestionAskerInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerInterface::class)->getMock();
    }
}
