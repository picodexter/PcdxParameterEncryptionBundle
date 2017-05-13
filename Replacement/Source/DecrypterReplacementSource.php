<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Replacement\Source;

use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
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
     * @var string|null
     */
    private $decryptionKey;

    /**
     * @var ReplacementPatternInterface
     */
    private $replacementPattern;

    /**
     * Constructor.
     *
     * @param DecrypterInterface          $decrypter
     * @param ReplacementPatternInterface $replacementPattern
     * @param string|null                 $decryptionKey
     */
    public function __construct(
        DecrypterInterface $decrypter,
        ReplacementPatternInterface $replacementPattern,
        $decryptionKey = null
    ) {
        $this->decrypter = $decrypter;
        $this->replacementPattern = $replacementPattern;
        $this->decryptionKey = $decryptionKey;
    }

    /**
     * @inheritDoc
     */
    public function getReplacedValueForParameter($key, $value)
    {
        return $this->decrypter->decryptValue(
            $this->replacementPattern->getValueWithoutPatternForParameter($key, $value),
            $this->decryptionKey
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
