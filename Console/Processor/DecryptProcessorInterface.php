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

namespace Picodexter\ParameterEncryptionBundle\Console\Processor;

use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DecryptProcessorInterface.
 */
interface DecryptProcessorInterface
{
    /**
     * Render decrypt output.
     *
     * @param DecryptRequest  $request
     * @param OutputInterface $output
     *
     * @throws UnknownAlgorithmIdException
     */
    public function renderDecryptOutput(DecryptRequest $request, OutputInterface $output);
}
