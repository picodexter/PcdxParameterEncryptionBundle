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

namespace Picodexter\ParameterEncryptionBundle\Console\Request;

use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;

/**
 * DecryptRequestFactoryInterface.
 */
interface DecryptRequestFactoryInterface
{
    /**
     * Create decrypt request.
     *
     * @param string                 $algorithmId
     * @param QuestionAskerInterface $encryptedAsker
     * @param string                 $encryptedValue
     * @param string                 $key
     * @param bool                   $keyProvided
     *
     * @return DecryptRequest
     */
    public function createDecryptRequest(
        $algorithmId,
        QuestionAskerInterface $encryptedAsker,
        $encryptedValue,
        $key,
        $keyProvided
    );
}
