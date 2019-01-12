<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Algorithm\CaesarCipher;

/**
 * CaesarCipher.
 */
class CaesarCipher implements CaesarCipherInterface
{
    /**
     * @var string All the characters that should be handled by the Caesar cipher. Lower case only.
     */
    const ALPHABET = 'abcdefghijklmnopqrstuvwxyz';

    /**
     * @inheritDoc
     */
    public function apply($inputText, $rotationAmount)
    {
        $rotationAmount = $this->getValidRotationAmount($rotationAmount);

        $outputText = '';

        for ($i = 0; $i < mb_strlen($inputText); ++$i) {
            $outputText .= $this->getRotatedCharacter(mb_substr($inputText, $i, 1), $rotationAmount);
        }

        return $outputText;
    }

    /**
     * Get alphabet size.
     *
     * @return int
     */
    private function getAlphabetSize()
    {
        return mb_strlen(self::ALPHABET);
    }

    /**
     * Get rotated character.
     *
     * @param string $character
     * @param int    $rotationAmount
     *
     * @return string
     */
    private function getRotatedCharacter($character, $rotationAmount)
    {
        $alphabetSize = $this->getAlphabetSize();

        $positionInAlphabet = mb_stripos(self::ALPHABET, $character);

        if (false === $positionInAlphabet) {
            $rotatedCharacter = $character;
        } else {
            $newCharacterOffset = (($positionInAlphabet + $rotationAmount + $alphabetSize) % $alphabetSize)
                - $positionInAlphabet;

            $rotatedCharacter = \chr(\ord($character) + $newCharacterOffset);
        }

        return $rotatedCharacter;
    }

    /**
     * Get valid rotation amount.
     *
     * @param int $rotationAmount
     *
     * @return int
     */
    private function getValidRotationAmount($rotationAmount)
    {
        $rotationAmount = (int) $rotationAmount;

        $alphabetSize = $this->getAlphabetSize();

        if ($rotationAmount < 0) {
            $rotationAmount += (int) ceil(-1 * $rotationAmount / $alphabetSize) * $alphabetSize;
        }

        return $rotationAmount;
    }
}
