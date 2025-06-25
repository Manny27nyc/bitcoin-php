/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Mnemonic;

interface WordListInterface extends \Countable
{
    /**
     * @return string[]
     */
    public function getWords(): array;

    /**
     * @param int $index
     * @return string
     */
    public function getWord(int $index): string;

    /**
     * @param string $word
     * @return integer
     */
    public function getIndex(string $word): int;
}
