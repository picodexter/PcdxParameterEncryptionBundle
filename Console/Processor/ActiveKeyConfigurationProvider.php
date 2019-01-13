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

namespace Picodexter\ParameterEncryptionBundle\Console\Processor;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfigurationFactoryInterface;

/**
 * ActiveKeyConfigurationProvider.
 */
class ActiveKeyConfigurationProvider implements ActiveKeyConfigurationProviderInterface
{
    /**
     * @var KeyConfigurationFactoryInterface
     */
    private $keyConfigFactory;

    /**
     * Constructor.
     *
     * @param KeyConfigurationFactoryInterface $keyConfigFactory
     */
    public function __construct(KeyConfigurationFactoryInterface $keyConfigFactory)
    {
        $this->keyConfigFactory = $keyConfigFactory;
    }

    /**
     * @inheritDoc
     */
    public function getActiveKeyConfiguration($isKeyProvided, $requestKey, KeyConfiguration $algorithmKeyConfig)
    {
        if (!$isKeyProvided) {
            return $algorithmKeyConfig;
        }

        return $this->keyConfigFactory->createKeyConfiguration([
            'value' => $requestKey,
        ]);
    }
}
