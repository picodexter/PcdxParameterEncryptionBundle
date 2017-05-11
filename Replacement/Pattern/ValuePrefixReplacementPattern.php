<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Replacement\Pattern;

/**
 * ValuePrefixReplacementPattern.
 */
class ValuePrefixReplacementPattern implements ReplacementPatternInterface
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * Constructor.
     *
     * @param string $prefix
     */
    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

    /**
     * @inheritDoc
     */
    public function getValueWithoutPatternForParameter($key, $value)
    {
        if ($this->isApplicableForParameter($key, $value)) {
            return mb_substr($value, mb_strlen($this->prefix));
        } else {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function isApplicableForParameter($key, $value)
    {
        if ($this->prefix) {
            return (mb_strpos($value, $this->prefix) === 0);
        } else {
            return false;
        }
    }
}
