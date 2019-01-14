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

namespace Picodexter\ParameterEncryptionBundle\Replacement\Pattern;

use Picodexter\ParameterEncryptionBundle\Exception\Configuration\EmptyPrefixException;

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
     *
     * @throws EmptyPrefixException
     */
    public function __construct($prefix)
    {
        $prefix = (string) $prefix;

        if (mb_strlen($prefix) < 1) {
            throw new EmptyPrefixException('Prefix cannot be empty');
        }

        $this->prefix = $prefix;
    }

    /**
     * @inheritDoc
     */
    public function getValueWithoutPatternForParameter($key, $value)
    {
        return (!$this->isApplicableForParameter($key, $value) ? null : mb_substr($value, mb_strlen($this->prefix)));
    }

    /**
     * @inheritDoc
     */
    public function isApplicableForParameter($key, $value)
    {
        return (0 === mb_strpos($value, $this->prefix));
    }
}
