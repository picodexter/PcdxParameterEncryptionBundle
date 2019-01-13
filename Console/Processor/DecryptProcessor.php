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
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DecryptProcessor.
 */
class DecryptProcessor implements DecryptProcessorInterface
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
    public function renderDecryptOutput(DecryptRequest $request, OutputInterface $output)
    {
        $this->algorithmIdValidator->assertKnownAlgorithmId($request->getAlgorithmId());

        $algorithmConfig = $this->algorithmConfigContainer->get($request->getAlgorithmId());

        $encryptedValue = $this->getEncryptedValue($request);

        $activeKeyConfig = $this->activeKeyConfigProvider->getActiveKeyConfiguration(
            $request->isKeyProvided(),
            $request->getKey(),
            $algorithmConfig->getDecryptionKeyConfig()
        );

        $transformedKey = $this->transformedKeyProvider->getTransformedKey($activeKeyConfig);

        $decryptedValue = $algorithmConfig->getDecrypter()
            ->decryptValue($encryptedValue, $transformedKey->getFinalKey());

        $this->renderer->renderOutput($decryptedValue, $transformedKey, $output);
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
}
