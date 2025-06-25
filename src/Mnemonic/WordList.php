/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Mnemonic;

abstract class WordList implements WordListInterface
{
    /**
     * @param int $index
     * @return string
     */
    public function getWord(int $index): string
    {
        $words = $this->getWords();
        if (!isset($words[$index])) {
            throw new \InvalidArgumentException(__CLASS__ . " does not contain a word for index [{$index}]");
        }

        return $words[$index];
    }
}
