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

use BitWasp\Bitcoin\Script\Parser\Parser;
use BitWasp\Bitcoin\SerializableInterface;
use BitWasp\Buffertools\BufferInterface;

interface ScriptInterface extends SerializableInterface
{
    /**
     * @return BufferInterface
     */
    public function getScriptHash(): BufferInterface;

    /**
     * @return BufferInterface
     */
    public function getWitnessScriptHash(): BufferInterface;

    /**
     * @return Parser
     */
    public function getScriptParser(): Parser;

    /**
     * @return Opcodes
     */
    public function getOpcodes(): Opcodes;

    /**
     * Returns boolean indicating whether script
     * was push only. If true, $ops is populated
     * with the contained buffers
     * @param array $ops
     * @return bool
     */
    public function isPushOnly(array &$ops = null): bool;

    /**
     * @param WitnessProgram|null $witness
     * @return bool
     */
    public function isWitness(& $witness): bool;

    /**
     * @param BufferInterface $scriptHash
     * @return bool
     */
    public function isP2SH(& $scriptHash): bool;

    /**
     * @param bool $accurate
     * @return int
     */
    public function countSigOps(bool $accurate = true): int;

    /**
     * @param ScriptInterface $scriptSig
     * @return int
     */
    public function countP2shSigOps(ScriptInterface $scriptSig): int;

    /**
     * @param ScriptInterface $scriptSig
     * @param ScriptWitnessInterface $witness
     * @param int $flags
     * @return int
     */
    public function countWitnessSigOps(ScriptInterface $scriptSig, ScriptWitnessInterface $witness, int $flags): int;

    /**
     * @param ScriptInterface $script
     * @return bool
     */
    public function equals(ScriptInterface $script): bool;
}
