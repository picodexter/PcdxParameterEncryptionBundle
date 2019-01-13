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

namespace Picodexter\ParameterEncryptionBundle\DependencyInjection\BundleConfiguration\ServiceDefinition;

/**
 * ArgumentReplacer.
 */
class ArgumentReplacer implements ArgumentReplacerInterface
{
    /**
     * @inheritDoc
     */
    public function replaceArgumentIfExists(array $arguments, array $replacements, $argumentKey)
    {
        $replacedArguments = $arguments;

        if (array_key_exists($argumentKey, $arguments) && array_key_exists($argumentKey, $replacements)) {
            $replacedArguments[$argumentKey] = $replacements[$argumentKey];
        }

        return $replacedArguments;
    }
}
