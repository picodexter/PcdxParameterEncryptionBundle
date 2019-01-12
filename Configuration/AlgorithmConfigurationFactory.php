<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfigurationFactoryInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Configuration\InvalidAlgorithmConfigurationException;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

/**
 * AlgorithmConfigurationFactory.
 */
class AlgorithmConfigurationFactory implements AlgorithmConfigurationFactoryInterface
{
    /**
     * @var KeyConfigurationFactoryInterface
     */
    private $keyConfigFactory;

    /**
     * Constructor.
     *
     * @param KeyConfigurationFactoryInterface $keyConfigFactory
     */
    public function __construct(KeyConfigurationFactoryInterface $keyConfigFactory)
    {
        $this->keyConfigFactory = $keyConfigFactory;
    }

    /**
     * @inheritDoc
     */
    public function createAlgorithmConfiguration(
        array $algorithmConfig,
        DecrypterInterface $decrypter,
        EncrypterInterface $encrypter,
        ReplacementPatternInterface $replacementPattern
    ) {
        $this->assertValidAlgorithmConfiguration($algorithmConfig);

        $decryptionKeyConfig = $this->keyConfigFactory->createKeyConfiguration($algorithmConfig['decryption']['key']);
        $encryptionKeyConfig = $this->keyConfigFactory->createKeyConfiguration($algorithmConfig['encryption']['key']);

        $algoId = $algorithmConfig['id'];
        $dcrptr = $decrypter;
        $dKeyCnf = $decryptionKeyConfig;
        $dSvcName = $algorithmConfig['decryption']['service'];
        $ecrptr = $encrypter;
        $eKeyCnf = $encryptionKeyConfig;
        $eSvcName = $algorithmConfig['encryption']['service'];
        $pttrn = $replacementPattern;

        return new AlgorithmConfiguration($algoId, $dcrptr, $dSvcName, $dKeyCnf, $ecrptr, $eSvcName, $eKeyCnf, $pttrn);
    }

    /**
     * Assert that algorithm configuration is valid.
     *
     * @param array $algorithmConfig
     *
     * @throws InvalidAlgorithmConfigurationException
     */
    private function assertValidAlgorithmConfiguration(array $algorithmConfig)
    {
        if (!array_key_exists('id', $algorithmConfig)
            || !$this->containsValidCryptoConfig($algorithmConfig, 'decryption')
            || !$this->containsValidCryptoConfig($algorithmConfig, 'encryption')
        ) {
            throw new InvalidAlgorithmConfigurationException();
        }
    }

    /**
     * Check if an algorithm configuration contains a valid crypto configuration.
     *
     * @param array  $algorithmConfig
     * @param string $type            'decryption' or 'encryption'
     *
     * @return bool
     */
    private function containsValidCryptoConfig($algorithmConfig, $type)
    {
        return (
            array_key_exists($type, $algorithmConfig)
            && \is_array($algorithmConfig[$type])
            && array_key_exists('key', $algorithmConfig[$type])
            && array_key_exists('service', $algorithmConfig[$type])
        );
    }
}
