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

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * AlgorithmListProcessor.
 */
class AlgorithmListProcessor implements AlgorithmListProcessorInterface
{
    /**
     * @var AlgorithmConfigurationContainerInterface
     */
    private $algorithmConfigContainer;

    /**
     * Constructor.
     *
     * @param AlgorithmConfigurationContainerInterface $algorithmContainer
     */
    public function __construct(AlgorithmConfigurationContainerInterface $algorithmContainer)
    {
        $this->algorithmConfigContainer = $algorithmContainer;
    }

    /**
     * @inheritDoc
     */
    public function renderAlgorithmListTable(Table $table)
    {
        $table->setHeaders(['Algorithm ID', 'Encryption class', 'Decryption class']);

        foreach ($this->algorithmConfigContainer->getAlgorithmConfigurations() as $algorithm) {
            $table->addRow([
                $algorithm->getId(),
                get_class($algorithm->getEncrypter()),
                get_class($algorithm->getDecrypter())
            ]);
        }

        $table->render();
    }
}
