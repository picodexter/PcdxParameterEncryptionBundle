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

use Picodexter\ParameterEncryptionBundle\Console\Helper\HiddenInputQuestionAskerGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\EncryptProcessorInterface;
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
     * @var HiddenInputQuestionAskerGeneratorInterface
     */
    private $questionAskerGenerator;

    /**
     * Constructor.
     *
     * @param EncryptRequestFactoryInterface             $requestFactory
     * @param EncryptProcessorInterface                  $processor
     * @param HiddenInputQuestionAskerGeneratorInterface $askerGenerator
     */
    public function __construct(
        EncryptRequestFactoryInterface $requestFactory,
        EncryptProcessorInterface $processor,
        HiddenInputQuestionAskerGeneratorInterface $askerGenerator
    ) {
        $this->encryptRequestFactory = $requestFactory;
        $this->processor = $processor;
        $this->questionAskerGenerator = $askerGenerator;
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

        $plaintextAsker = $this->questionAskerGenerator->generateHiddenInputQuestionAsker(
            'Plaintext value to be encrypted (hidden input): ',
            $input,
            $output
        );

        return $this->encryptRequestFactory
            ->createEncryptRequest($algorithmId, $key, $keyProvided, $plaintextAsker, $plaintextValue);
    }
}
