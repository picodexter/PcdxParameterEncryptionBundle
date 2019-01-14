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

namespace Picodexter\ParameterEncryptionBundle\Console\Dispatcher;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DispatcherInterface.
 */
interface DispatcherInterface
{
    /**
     * Dispatch input and output to processor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function dispatchToProcessor(InputInterface $input, OutputInterface $output);
}
