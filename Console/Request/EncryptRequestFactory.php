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
 * EncryptRequestFactory.
 */
class EncryptRequestFactory implements EncryptRequestFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createEncryptRequest(
        $algorithmId,
        $key,
        $keyProvided,
        QuestionAskerInterface $plaintextAsker,
        $plaintextValue
    ) {
        return new EncryptRequest($algorithmId, $key, $keyProvided, $plaintextAsker, $plaintextValue);
    }
}
