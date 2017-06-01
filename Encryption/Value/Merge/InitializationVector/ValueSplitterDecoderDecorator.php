<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Value\Merge\InitializationVector;

use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\DecoderInterface;

/**
 * ValueSplitterDecoderDecorator.
 */
class ValueSplitterDecoderDecorator implements ValueSplitterInterface
{
    /**
     * @var DecoderInterface
     */
    private $decoder;

    /**
     * @var ValueSplitterInterface
     */
    private $valueSplitter;

    /**
     * Constructor.
     *
     * @param DecoderInterface       $decoder
     * @param ValueSplitterInterface $valueSplitter
     */
    public function __construct(DecoderInterface $decoder, ValueSplitterInterface $valueSplitter)
    {
        $this->decoder = $decoder;
        $this->valueSplitter = $valueSplitter;
    }

    /**
     * @inheritDoc
     */
    public function split($mergedValue, $ivLength)
    {
        $unencodedValue = $this->decoder->decode($mergedValue);

        return $this->valueSplitter->split($unencodedValue, $ivLength);
    }
}
