/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Block;

use BitWasp\Bitcoin\Bloom\BloomFilter;
use BitWasp\Bitcoin\SerializableInterface;
use BitWasp\Bitcoin\Transaction\TransactionInterface;
use BitWasp\Buffertools\BufferInterface;

interface BlockInterface extends SerializableInterface
{
    const MAX_BLOCK_SIZE = 1000000;

    /**
     * Get the header of this block.
     *
     * @return BlockHeaderInterface
     */
    public function getHeader(): BlockHeaderInterface;

    /**
     * Calculate the merkle root of the transactions in the block.
     *
     * @return BufferInterface
     */
    public function getMerkleRoot(): BufferInterface;

    /**
     * Return the block's transactions.
     *
     * @return TransactionInterface[]
     */
    public function getTransactions(): array;

    /**
     * @param int $i
     * @return TransactionInterface
     */
    public function getTransaction(int $i): TransactionInterface;

    /**
     * @param BloomFilter $filter
     * @return FilteredBlock
     */
    public function filter(BloomFilter $filter): FilteredBlock;
}
