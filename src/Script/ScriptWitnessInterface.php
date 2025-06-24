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

namespace BitWasp\Bitcoin\Script;

use BitWasp\Bitcoin\Collection\CollectionInterface;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\SerializableInterface;

interface ScriptWitnessInterface extends CollectionInterface, SerializableInterface
{
    /**
     * @return BufferInterface[]
     */
    public function all(): array;

    /**
     * @param ScriptWitnessInterface $witness
     * @return bool
     */
    public function equals(ScriptWitnessInterface $witness): bool;
}
