<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Helper;

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;

/**
 * AlgorithmIdValidator.
 */
class AlgorithmIdValidator implements AlgorithmIdValidatorInterface
{
    /**
     * @var AlgorithmConfigurationContainerInterface
     */
    private $algorithmConfigContainer;

    /**
     * Constructor.
     *
     * @param AlgorithmConfigurationContainerInterface $configContainer
     */
    public function __construct(AlgorithmConfigurationContainerInterface $configContainer)
    {
        $this->algorithmConfigContainer = $configContainer;
    }

    /**
     * @inheritDoc
     */
    public function assertKnownAlgorithmId($algorithmId)
    {
        if (!$this->algorithmConfigContainer->has($algorithmId)) {
            throw new UnknownAlgorithmIdException($algorithmId);
        }
    }
}
