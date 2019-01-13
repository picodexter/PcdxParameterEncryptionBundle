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

namespace Picodexter\ParameterEncryptionBundle\Command;

use Picodexter\ParameterEncryptionBundle\Console\Dispatcher\AlgorithmListDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * AlgorithmListCommand.
 */
class AlgorithmListCommand extends Command
{
    /**
     * @var AlgorithmListDispatcherInterface
     */
    private $dispatcher;

    /**
     * Constructor.
     *
     * @param AlgorithmListDispatcherInterface $dispatcher
     */
    public function __construct(AlgorithmListDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('pcdx-parameter-encryption:algorithm:list')
            ->setDescription('List configured algorithms.');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dispatcher->dispatchToProcessor($input, $output);
    }
}
