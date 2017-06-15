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

use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\Base64EncoderInterface;

/**
 * TransformedKeyFactory.
 */
class TransformedKeyFactory implements TransformedKeyFactoryInterface
{
    /**
     * @var Base64EncoderInterface
     */
    private $base64Encoder;

    /**
     * Constructor.
     *
     * @param Base64EncoderInterface $base64Encoder
     */
    public function __construct(Base64EncoderInterface $base64Encoder)
    {
        $this->base64Encoder = $base64Encoder;
    }

    /**
     * @inheritDoc
     */
    public function createTransformedKey($originalKey, $finalKey)
    {
        $transformedKey = new TransformedKey();

        $transformedKey->setFinalKey($finalKey);
        $transformedKey->setFinalKeyEncoded($this->base64Encoder->encode($finalKey));
        $transformedKey->setOriginalKey($originalKey);

        return $transformedKey;
    }
}
