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

namespace Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\Base64DecoderInterface;

/**
 * Base64DecoderKeyTransformer.
 */
class Base64DecoderKeyTransformer implements KeyTransformerInterface
{
    /**
     * @var Base64DecoderInterface
     */
    private $base64Decoder;

    /**
     * Constructor.
     *
     * @param Base64DecoderInterface $base64Decoder
     */
    public function __construct(Base64DecoderInterface $base64Decoder)
    {
        $this->base64Decoder = $base64Decoder;
    }

    /**
     * @inheritDoc
     */
    public function appliesFor($key, KeyConfiguration $keyConfig)
    {
        return $keyConfig->isBase64Encoded();
    }

    /**
     * @inheritDoc
     */
    public function transform($key, KeyConfiguration $keyConfig)
    {
        return $this->base64Decoder->decode($key);
    }
}
