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

namespace BitWasp\Bitcoin\Block;

use BitWasp\Bitcoin\SerializableInterface;
use BitWasp\Buffertools\BufferInterface;

interface BlockHeaderInterface extends SerializableInterface
{
    /**
     * Return the version of this block.
     *
     * @return int
     */
    public function getVersion(): int;

    /**
     * Return the version of this block.
     *
     * @return bool
     */
    public function hasBip9Prefix(): bool;

    /**
     * Return the previous blocks hash.
     *
     * @return BufferInterface
     */
    public function getPrevBlock(): BufferInterface;

    /**
     * Return the merkle root of the transactions in the block.
     *
     * @return BufferInterface
     */
    public function getMerkleRoot(): BufferInterface;

    /**
     * Get the timestamp of the block.
     *
     * @return int
     */
    public function getTimestamp(): int;

    /**
     * Return the buffer containing the short representation of the difficulty
     *
     * @return int
     */
    public function getBits(): int;

    /**
     * Return the nonce of the block header.
     *
     * @return int
     */
    public function getNonce(): int;

    /**
     * Return whether this header is equal to the other.
     *
     * @param BlockHeaderInterface $header
     * @return bool
     */
    public function equals(self $header): bool;

    /**
     * @return BufferInterface
     */
    public function getHash(): BufferInterface;
}
