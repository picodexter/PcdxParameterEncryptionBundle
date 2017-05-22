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

use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * EncryptProcessorInterface.
 */
interface EncryptProcessorInterface
{
    /**
     * Render encrypt output.
     *
     * @param EncryptRequest  $request
     * @param OutputInterface $output
     * @throws UnknownAlgorithmIdException
     */
    public function renderEncryptOutput(EncryptRequest $request, OutputInterface $output);
}
