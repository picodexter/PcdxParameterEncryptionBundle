<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Renderer;

use Picodexter\ParameterEncryptionBundle\Console\Renderer\AbstractCryptRenderer;

/**
 * DummyAbstractCryptRenderer.
 */
class DummyAbstractCryptRenderer extends AbstractCryptRenderer
{
    const MESSAGE_FOR_GENERATED_KEY = 'message for generated key';
    const MESSAGE_FOR_RESULT = 'message for result';
    const MESSAGE_FOR_STATIC_KEY = 'message for static key';

    /**
     * @inheritDoc
     */
    public function getMessageForGeneratedKey()
    {
        return self::MESSAGE_FOR_GENERATED_KEY;
    }

    /**
     * @inheritDoc
     */
    public function getMessageForResult()
    {
        return self::MESSAGE_FOR_RESULT;
    }

    /**
     * @inheritDoc
     */
    public function getMessageForStaticKey()
    {
        return self::MESSAGE_FOR_STATIC_KEY;
    }
}
