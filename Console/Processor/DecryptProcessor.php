<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Processor;

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\AlgorithmIdValidatorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DecryptProcessor.
 */
class DecryptProcessor implements DecryptProcessorInterface
{
    /**
     * @var AlgorithmConfigurationContainerInterface
     */
    private $algorithmConfigContainer;

    /**
     * @var AlgorithmIdValidatorInterface
     */
    private $algorithmIdValidator;

    /**
     * Constructor.
     *
     * @param AlgorithmConfigurationContainerInterface $algorithmContainer
     * @param AlgorithmIdValidatorInterface            $algorithmIdValidator
     */
    public function __construct(
        AlgorithmConfigurationContainerInterface $algorithmContainer,
        AlgorithmIdValidatorInterface $algorithmIdValidator
    ) {
        $this->algorithmConfigContainer = $algorithmContainer;
        $this->algorithmIdValidator = $algorithmIdValidator;
    }

    /**
     * Get key.
     *
     * @param DecryptRequest $request
     * @param string         $configKey
     *
     * @return string|null
     */
    private function getKey(DecryptRequest $request, $configKey)
    {
        if (!$request->isKeyProvided()) {
            $key = $configKey;
        } else {
            $key = $request->getKey();
        }

        return $key;
    }

    /**
     * Get encrypted value.
     *
     * @param DecryptRequest $request
     *
     * @return string
     */
    private function getEncryptedValue(DecryptRequest $request)
    {
        if (!$request->getEncryptedValue()) {
            $plaintextValue = $request->getEncryptedQuestionAsker()->askQuestion();
        } else {
            $plaintextValue = $request->getEncryptedValue();
        }

        return $plaintextValue;
    }

    /**
     * @inheritDoc
     */
    public function renderDecryptOutput(DecryptRequest $request, OutputInterface $output)
    {
        $this->algorithmIdValidator->assertKnownAlgorithmId($request->getAlgorithmId());

        $algorithmConfig = $this->algorithmConfigContainer->get($request->getAlgorithmId());

        $plaintextValue = $this->getEncryptedValue($request);

        $key = $this->getKey($request, $algorithmConfig->getDecryptionKey());

        $decryptedValue = $algorithmConfig->getDecrypter()->decryptValue($plaintextValue, $key);

        $this->renderOutput($decryptedValue, $key, $output);
    }

    /**
     * Render output.
     *
     * @param string          $decryptedValue
     * @param string          $key
     * @param OutputInterface $output
     */
    private function renderOutput($decryptedValue, $key, OutputInterface $output)
    {
        if (OutputInterface::VERBOSITY_QUIET === $output->getVerbosity()) {
            $output->writeln($decryptedValue, OutputInterface::VERBOSITY_QUIET);
        } else {
            $output->writeln('Decryption key:  "'.$key.'"');
            $output->writeln('Decrypted value: "'.$decryptedValue.'"');
        }
    }
}
