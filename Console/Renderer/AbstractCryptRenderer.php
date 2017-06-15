<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Renderer;

use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKey;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * AbstractCryptRenderer.
 */
abstract class AbstractCryptRenderer implements CryptRendererInterface
{
    /**
     * Get message for generated key.
     *
     * Used with sprintf().
     *
     * @return string
     */
    abstract public function getMessageForGeneratedKey();

    /**
     * Get message for result.
     *
     * Used with sprintf().
     *
     * @return string
     */
    abstract public function getMessageForResult();

    /**
     * Get message for static key.
     *
     * Used with sprintf().
     *
     * @return string
     */
    abstract public function getMessageForStaticKey();

    /**
     * @inheritDoc
     */
    public function renderOutput($result, TransformedKey $transformedKey, OutputInterface $output)
    {
        if (OutputInterface::VERBOSITY_QUIET === $output->getVerbosity()) {
            $output->writeln($result, OutputInterface::VERBOSITY_QUIET);
        } else {
            if ($transformedKey->hasChanged()) {
                $output->writeln(
                    sprintf($this->getMessageForGeneratedKey(), $transformedKey->getFinalKeyEncoded())
                );
            } else {
                $output->writeln(sprintf($this->getMessageForStaticKey(), $transformedKey->getFinalKey()));
            }

            $output->writeln(sprintf($this->getMessageForResult(), $result));
        }
    }
}
