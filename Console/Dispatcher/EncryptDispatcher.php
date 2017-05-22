<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Dispatcher;

use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\EncryptProcessorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Question\QuestionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequestFactoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * EncryptDispatcher.
 */
class EncryptDispatcher implements EncryptDispatcherInterface
{
    /**
     * @var EncryptRequestFactoryInterface
     */
    private $encryptRequestFactory;

    /**
     * @var EncryptProcessorInterface
     */
    private $processor;

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
     * @param EncryptRequestFactoryInterface  $requestFactory
     * @param EncryptProcessorInterface       $processor
     * @param QuestionAskerGeneratorInterface $askerGenerator
     * @param QuestionFactoryInterface        $questionFactory
     */
    public function __construct(
        EncryptRequestFactoryInterface $requestFactory,
        EncryptProcessorInterface $processor,
        QuestionAskerGeneratorInterface $askerGenerator,
        QuestionFactoryInterface $questionFactory
    ) {
        $this->encryptRequestFactory = $requestFactory;
        $this->processor = $processor;
        $this->questionAskerGenerator = $askerGenerator;
        $this->questionFactory = $questionFactory;
    }

    /**
     * @inheritDoc
     */
    public function dispatchToProcessor(InputInterface $input, OutputInterface $output)
    {
        $request = $this->generateEncryptRequest($input, $output);

        $this->processor->renderEncryptOutput($request, $output);
    }

    /**
     * Generate encrypt request.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return EncryptRequest
     */
    private function generateEncryptRequest(InputInterface $input, OutputInterface $output)
    {
        $algorithmId = $input->getArgument('algorithm_id');
        $plaintextValue = $input->getArgument('plaintext_value');
        $key = $input->getOption('key');
        $keyProvided = $input->hasParameterOption(['--key', '-k']);

        $plaintextAsker = $this->generatePlaintextValueQuestionAsker($input, $output);

        return $this->encryptRequestFactory
            ->createEncryptRequest($algorithmId, $key, $keyProvided, $plaintextAsker, $plaintextValue);
    }

    /**
     * Generate question asker for plaintext value.
     *
     * Will be used in case none was provided as an input argument.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return QuestionAskerInterface
     */
    private function generatePlaintextValueQuestionAsker(InputInterface $input, OutputInterface $output)
    {
        $question = $this->questionFactory->createQuestion('Plaintext value to be encrypted (hidden input): ');
        $question->setHidden(true);
        $question->setHiddenFallback(true);

        return $this->questionAskerGenerator->createQuestionAskerForQuestion($question, $input, $output);
    }
}
