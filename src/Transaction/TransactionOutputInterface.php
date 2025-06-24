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

namespace BitWasp\Bitcoin\Transaction;

use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\SerializableInterface;

interface TransactionOutputInterface extends SerializableInterface
{
    /**
     * Get the value of this output
     *
     * @return int
     */
    public function getValue(): int;

    /**
     * Get the script for this output
     *
     * @return ScriptInterface
     */
    public function getScript(): ScriptInterface;

    /**
     * @param TransactionOutputInterface $output
     * @return bool
     */
    public function equals(TransactionOutputInterface $output): bool;
}
