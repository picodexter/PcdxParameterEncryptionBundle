<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Command;

use Picodexter\ParameterEncryptionBundle\Console\Dispatcher\DecryptDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DecryptCommand.
 */
class DecryptCommand extends Command
{
    /**
     * @var DecryptDispatcherInterface
     */
    private $dispatcher;

    /**
     * Constructor.
     *
     * @param DecryptDispatcherInterface $dispatcher
     */
    public function __construct(DecryptDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('pcdx-parameter-encryption:decrypt')
            ->setDescription('Decrypt a value with a specified algorithm.')
            ->addArgument('algorithm_id', InputArgument::REQUIRED, 'Algorithm ID')
            ->addArgument(
                'encrypted_value',
                InputArgument::OPTIONAL,
                'Encrypted value (optional, will be prompted for if not supplied)'
            )
            ->addOption(
                'key',
                'k',
                InputOption::VALUE_OPTIONAL,
                'Encryption key (optional, will be taken from algorithm configuration if not supplied)',
                ''
            );
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dispatcher->dispatchToProcessor($input, $output);
    }
}
