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

namespace Picodexter\ParameterEncryptionBundle\Console\Dispatcher;

use Picodexter\ParameterEncryptionBundle\Console\Helper\HiddenInputQuestionAskerGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\DecryptProcessorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequestFactoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DecryptDispatcher.
 */
class DecryptDispatcher implements DecryptDispatcherInterface
{
    /**
     * @var DecryptRequestFactoryInterface
     */
    private $decryptRequestFactory;

    /**
     * @var DecryptProcessorInterface
     */
    private $processor;

    /**
     * @var HiddenInputQuestionAskerGeneratorInterface
     */
    private $questionAskerGenerator;

    /**
     * Constructor.
     *
     * @param DecryptRequestFactoryInterface             $requestFactory
     * @param DecryptProcessorInterface                  $processor
     * @param HiddenInputQuestionAskerGeneratorInterface $askerGenerator
     */
    public function __construct(
        DecryptRequestFactoryInterface $requestFactory,
        DecryptProcessorInterface $processor,
        HiddenInputQuestionAskerGeneratorInterface $askerGenerator
    ) {
        $this->decryptRequestFactory = $requestFactory;
        $this->processor = $processor;
        $this->questionAskerGenerator = $askerGenerator;
    }

    /**
     * @inheritDoc
     */
    public function dispatchToProcessor(InputInterface $input, OutputInterface $output)
    {
        $request = $this->generateDecryptRequest($input, $output);

        $this->processor->renderDecryptOutput($request, $output);
    }

    /**
     * Generate decrypt request.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return DecryptRequest
     */
    private function generateDecryptRequest(InputInterface $input, OutputInterface $output)
    {
        $algorithmId = $input->getArgument('algorithm_id');
        $encryptedValue = $input->getArgument('encrypted_value');
        $key = $input->getOption('key');
        $keyProvided = $input->hasParameterOption(['--key', '-k']);

        $questionText = 'Encrypted value to be decrypted (hidden input): ';
        $encryptedAsker = $this->questionAskerGenerator
            ->generateHiddenInputQuestionAsker($questionText, $input, $output);

        return $this->decryptRequestFactory
            ->createDecryptRequest($algorithmId, $encryptedAsker, $encryptedValue, $key, $keyProvided);
    }
}
