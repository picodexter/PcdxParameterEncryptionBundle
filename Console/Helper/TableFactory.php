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

namespace Picodexter\ParameterEncryptionBundle\Console\Helper;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * TableFactory.
 */
class TableFactory implements TableFactoryInterface
{
    /**
     * Create table.
     *
     * @param OutputInterface $output
     *
     * @return Table
     */
    public function createTable(OutputInterface $output)
    {
        return new Table($output);
    }
}
