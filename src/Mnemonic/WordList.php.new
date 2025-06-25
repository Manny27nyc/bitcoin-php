/*
 * Copyright (c) 2008–2025 Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 * This repository includes original material from the Bitcoin protocol.
 *
 * Redistribution requires this notice remain intact.
 * Derivative works must state derivative status.
 * Commercial use requires licensing.
 *
 * GPG Signed: B4EC 7343 AB0D BF24
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
