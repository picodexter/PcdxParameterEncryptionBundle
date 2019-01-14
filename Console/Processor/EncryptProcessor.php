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

namespace Picodexter\ParameterEncryptionBundle\Console\Processor;

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\AlgorithmIdValidatorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Renderer\CryptRendererInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * EncryptProcessor.
 */
class EncryptProcessor implements EncryptProcessorInterface
{
    /**
     * @var ActiveKeyConfigurationProviderInterface
     */
    private $activeKeyConfigProvider;

    /**
     * @var AlgorithmConfigurationContainerInterface
     */
    private $algorithmConfigContainer;

    /**
     * @var AlgorithmIdValidatorInterface
     */
    private $algorithmIdValidator;

    /**
     * @var CryptRendererInterface
     */
    private $renderer;

    /**
     * @var TransformedKeyProviderInterface
     */
    private $transformedKeyProvider;

    /**
     * Constructor.
     *
     * @param ActiveKeyConfigurationProviderInterface  $activeKeyCnfProvider
     * @param AlgorithmConfigurationContainerInterface $algorithmContainer
     * @param AlgorithmIdValidatorInterface            $algorithmIdValidator
     * @param CryptRendererInterface                   $renderer
     * @param TransformedKeyProviderInterface          $transfKeyProvider
     */
    public function __construct(
        ActiveKeyConfigurationProviderInterface $activeKeyCnfProvider,
        AlgorithmConfigurationContainerInterface $algorithmContainer,
        AlgorithmIdValidatorInterface $algorithmIdValidator,
        CryptRendererInterface $renderer,
        TransformedKeyProviderInterface $transfKeyProvider
    ) {
        $this->activeKeyConfigProvider = $activeKeyCnfProvider;
        $this->algorithmConfigContainer = $algorithmContainer;
        $this->algorithmIdValidator = $algorithmIdValidator;
        $this->renderer = $renderer;
        $this->transformedKeyProvider = $transfKeyProvider;
    }

    /**
     * @inheritDoc
     */
    public function renderEncryptOutput(EncryptRequest $request, OutputInterface $output)
    {
        $this->algorithmIdValidator->assertKnownAlgorithmId($request->getAlgorithmId());

        $algorithmConfig = $this->algorithmConfigContainer->get($request->getAlgorithmId());

        $plaintextValue = $this->getPlaintextValue($request);

        $activeKeyConfig = $this->activeKeyConfigProvider->getActiveKeyConfiguration(
            $request->isKeyProvided(),
            $request->getKey(),
            $algorithmConfig->getEncryptionKeyConfig()
        );

        $transformedKey = $this->transformedKeyProvider->getTransformedKey($activeKeyConfig);

        $encryptedValue = $algorithmConfig->getEncrypter()
            ->encryptValue($plaintextValue, $transformedKey->getFinalKey());

        $this->renderer->renderOutput($encryptedValue, $transformedKey, $output);
    }

    /**
     * Get plaintext value.
     *
     * @param EncryptRequest $request
     *
     * @return string
     */
    private function getPlaintextValue(EncryptRequest $request)
    {
        if (!$request->getPlaintextValue()) {
            $plaintextValue = $request->getPlaintextQuestionAsker()->askQuestion();
        } else {
            $plaintextValue = $request->getPlaintextValue();
        }

        return $plaintextValue;
    }
}
