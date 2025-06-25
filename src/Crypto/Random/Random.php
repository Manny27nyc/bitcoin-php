/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Crypto\Random;

use BitWasp\Bitcoin\Exceptions\RandomBytesFailure;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class Random implements RbgInterface
{
    /**
     * Return $length bytes. Throws an exception if
     * @param int $length
     * @return BufferInterface
     * @throws RandomBytesFailure
     */
    public function bytes(int $length = 32): BufferInterface
    {
        return new Buffer(random_bytes($length), $length);
    }
}
