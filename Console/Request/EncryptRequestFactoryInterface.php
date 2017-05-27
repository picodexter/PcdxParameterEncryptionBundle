<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Request;

use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;

/**
 * EncryptRequestFactoryInterface.
 */
interface EncryptRequestFactoryInterface
{
    /**
     * Create encrypt request.
     *
     * @param string                 $algorithmId
     * @param string|null            $key
     * @param bool                   $keyProvided
     * @param QuestionAskerInterface $plaintextAsker
     * @param string                 $plaintextValue
     *
     * @return EncryptRequest
     */
    public function createEncryptRequest(
        $algorithmId,
        $key,
        $keyProvided,
        QuestionAskerInterface $plaintextAsker,
        $plaintextValue
    );
}
