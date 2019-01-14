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

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\KeyFetcherInterface;

/**
 * TransformedKeyProvider.
 */
class TransformedKeyProvider implements TransformedKeyProviderInterface
{
    /**
     * @var KeyFetcherInterface
     */
    private $keyFetcher;

    /**
     * @var TransformedKeyFactoryInterface
     */
    private $transformedKeyFactory;

    /**
     * Constructor.
     *
     * @param KeyFetcherInterface            $keyFetcher
     * @param TransformedKeyFactoryInterface $transfKeyFactory
     */
    public function __construct(
        KeyFetcherInterface $keyFetcher,
        TransformedKeyFactoryInterface $transfKeyFactory
    ) {
        $this->keyFetcher = $keyFetcher;
        $this->transformedKeyFactory = $transfKeyFactory;
    }

    /**
     * @inheritDoc
     */
    public function getTransformedKey(KeyConfiguration $keyConfig)
    {
        $originalKey = $keyConfig->getValue();

        $finalKey = $this->keyFetcher->getKeyForConfig($keyConfig);

        $keyContainer = $this->transformedKeyFactory->createTransformedKey($originalKey, $finalKey);

        return $keyContainer;
    }
}
