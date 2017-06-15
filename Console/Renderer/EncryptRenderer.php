<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Renderer;

/**
 * EncryptRenderer.
 */
class EncryptRenderer extends AbstractCryptRenderer
{
    /**
     * @inheritDoc
     */
    public function getMessageForGeneratedKey()
    {
        return 'Generated encryption key (base64 encoded): "%s"';
    }

    /**
     * @inheritDoc
     */
    public function getMessageForResult()
    {
        return 'Encrypted value: "%s"';
    }

    /**
     * @inheritDoc
     */
    public function getMessageForStaticKey()
    {
        return 'Encryption key: "%s"';
    }
}
