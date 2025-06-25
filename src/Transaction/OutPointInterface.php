/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Transaction;

use BitWasp\Bitcoin\SerializableInterface;
use BitWasp\Buffertools\BufferInterface;

interface OutPointInterface extends SerializableInterface
{
    /**
     * @return BufferInterface
     */
    public function getTxId(): BufferInterface;

    /**
     * @return int
     */
    public function getVout(): int;

    /**
     * @param OutPointInterface $outPoint
     * @return bool
     */
    public function equals(OutPointInterface $outPoint): bool;
}
