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
 * DecryptRequestFactory.
 */
class DecryptRequestFactory implements DecryptRequestFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createDecryptRequest(
        $algorithmId,
        QuestionAskerInterface $encryptedAsker,
        $encryptedValue,
        $key,
        $keyProvided
    ) {
        return new DecryptRequest($algorithmId, $encryptedAsker, $encryptedValue, $key, $keyProvided);
    }
}
