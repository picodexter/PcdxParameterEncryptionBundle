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

namespace Picodexter\ParameterEncryptionBundle\Replacement\Source;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyFetcherInterface;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface;

/**
 * DecrypterReplacementSource.
 */
class DecrypterReplacementSource implements ReplacementSourceInterface
{
    /**
     * @var DecrypterInterface
     */
    private $decrypter;

    /**
     * @var KeyConfiguration
     */
    private $decryptionKeyConfig;

    /**
     * @var KeyFetcherInterface
     */
    private $keyFetcher;

    /**
     * @var ReplacementPatternInterface
     */
    private $replacementPattern;

    /**
     * Constructor.
     *
     * @param DecrypterInterface          $decrypter
     * @param KeyConfiguration            $decryptionKeyConfig
     * @param KeyFetcherInterface         $keyFetcher
     * @param ReplacementPatternInterface $replacementPattern
     */
    public function __construct(
        DecrypterInterface $decrypter,
        KeyConfiguration $decryptionKeyConfig,
        KeyFetcherInterface $keyFetcher,
        ReplacementPatternInterface $replacementPattern
    ) {
        $this->decrypter = $decrypter;
        $this->decryptionKeyConfig = $decryptionKeyConfig;
        $this->keyFetcher = $keyFetcher;
        $this->replacementPattern = $replacementPattern;
    }

    /**
     * @inheritDoc
     */
    public function getReplacedValueForParameter($key, $value)
    {
        $decryptionKey = $this->keyFetcher->getKeyForConfig($this->decryptionKeyConfig);

        return $this->decrypter->decryptValue(
            $this->replacementPattern->getValueWithoutPatternForParameter($key, $value),
            $decryptionKey
        );
    }

    /**
     * @inheritDoc
     */
    public function isApplicableForParameter($key, $value)
    {
        return $this->replacementPattern->isApplicableForParameter($key, $value);
    }
}
