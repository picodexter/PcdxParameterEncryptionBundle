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

use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\EncoderInterface;

/**
 * ValueMergerEncoderDecorator.
 */
class ValueMergerEncoderDecorator implements ValueMergerInterface
{
    /**
     * @var EncoderInterface;
     */
    private $encoder;

    /**
     * @var ValueMergerInterface
     */
    private $valueMerger;

    /**
     * Constructor.
     *
     * @param EncoderInterface     $encoder
     * @param ValueMergerInterface $valueMerger
     */
    public function __construct(EncoderInterface $encoder, ValueMergerInterface $valueMerger)
    {
        $this->encoder = $encoder;
        $this->valueMerger = $valueMerger;
    }

    /**
     * @inheritDoc
     */
    public function merge($encryptedValue, $initializationVector)
    {
        $mergedValue = $this->valueMerger->merge($encryptedValue, $initializationVector);

        return $this->encoder->encode($mergedValue);
    }
}
