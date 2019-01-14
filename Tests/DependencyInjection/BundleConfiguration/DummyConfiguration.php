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

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\BundleConfiguration;

use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * DummyConfiguration.
 */
class DummyConfiguration implements ConfigurationInterface
{
    /**
     * @var mixed
     */
    public $argumentOne;

    /**
     * @var mixed
     */
    public $argumentTwo;

    /**
     * Constructor.
     *
     * @param mixed $argumentOne
     * @param mixed $argumentTwo
     */
    public function __construct($argumentOne = null, $argumentTwo = null)
    {
        $this->argumentOne = $argumentOne;
        $this->argumentTwo = $argumentTwo;
    }

    public function getConfigTreeBuilder()
    {
    }
}
