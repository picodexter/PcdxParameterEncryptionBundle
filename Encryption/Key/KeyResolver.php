<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Key;

use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Encryption\Key\Transformer\KeyTransformerInterface;

/**
 * KeyResolver.
 */
class KeyResolver implements KeyResolverInterface
{
    /**
     * @var KeyTransformerInterface[]
     */
    private $transformers;

    /**
     * Constructor.
     *
     * @param KeyTransformerInterface[] $transformers
     */
    public function __construct(array $transformers)
    {
        $this->setTransformers($transformers);
    }

    /**
     * Setter: transformers.
     *
     * @param KeyTransformerInterface[] $transformers
     */
    public function setTransformers(array $transformers)
    {
        $this->transformers = [];

        foreach ($transformers as $transformer) {
            if ($transformer instanceof KeyTransformerInterface) {
                $this->addTransformer($transformer);
            }
        }
    }

    /**
     * Resolve key configuration to key.
     *
     * @param KeyConfiguration $keyConfig
     *
     * @return string|null
     */
    public function resolveKey(KeyConfiguration $keyConfig)
    {
        $key = $keyConfig->getValue();

        foreach ($this->transformers as $transformer) {
            if ($transformer->appliesFor($key, $keyConfig)) {
                $key = $transformer->transform($key, $keyConfig);
            }
        }

        return $key;
    }

    /**
     * Add a key transformer.
     *
     * Will not add it if one of the same class has already been added.
     *
     * @param KeyTransformerInterface $keyTransformer
     */
    private function addTransformer(KeyTransformerInterface $keyTransformer)
    {
        $finds = array_filter($this->transformers, function ($transformer) use ($keyTransformer) {
            return (get_class($transformer) === get_class($keyTransformer));
        });

        if (count($finds) < 1) {
            $this->transformers[] = $keyTransformer;
        }
    }
}
