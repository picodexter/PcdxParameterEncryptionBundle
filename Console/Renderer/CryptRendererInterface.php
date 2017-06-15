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
 * CryptRendererInterface.
 */
interface CryptRendererInterface
{
    /**
     * Render output.
     *
     * @param string          $result
     * @param TransformedKey  $transformedKey
     * @param OutputInterface $output
     */
    public function renderOutput($result, TransformedKey $transformedKey, OutputInterface $output);
}
