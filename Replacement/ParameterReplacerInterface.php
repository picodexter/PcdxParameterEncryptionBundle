<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Replacement;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * ParameterReplacerInterface.
 */
interface ParameterReplacerInterface
{
    /**
     * Process parameter bag.
     *
     * Applies changes to the original object.
     *
     * @param ParameterBagInterface $parameterBag
     * @return ParameterBagInterface
     */
    public function processParameterBag(ParameterBagInterface $parameterBag);
}
