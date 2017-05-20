<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Dispatcher;

use Picodexter\ParameterEncryptionBundle\Console\Helper\TableFactoryInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\AlgorithmListProcessorInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * AlgorithmListDispatcher.
 */
class AlgorithmListDispatcher implements AlgorithmListDispatcherInterface
{
    /**
     * @var AlgorithmListProcessorInterface
     */
    private $processor;

    /**
     * @var TableFactoryInterface
     */
    private $tableFactory;

    /**
     * Constructor.
     *
     * @param AlgorithmListProcessorInterface $processor
     * @param TableFactoryInterface           $tableFactory
     */
    public function __construct(AlgorithmListProcessorInterface $processor, TableFactoryInterface $tableFactory)
    {
        $this->processor = $processor;
        $this->tableFactory = $tableFactory;
    }

    /**
     * @inheritDoc
     */
    public function dispatchToProcessor(InputInterface $input, OutputInterface $output)
    {
        $table = $this->tableFactory->createTable($output);

        $this->processor->renderAlgorithmListTable($table);
    }
}
