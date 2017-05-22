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

use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;

/**
 * AlgorithmIdValidatorInterface.
 */
interface AlgorithmIdValidatorInterface
{
    /**
     * Assert that algorithm ID exists.
     *
     * @param string $algorithmId
     * @throws UnknownAlgorithmIdException
     */
    public function assertKnownAlgorithmId($algorithmId);
}
