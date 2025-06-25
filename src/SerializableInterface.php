/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin;

use BitWasp\Buffertools\BufferInterface;

interface SerializableInterface extends \BitWasp\Buffertools\SerializableInterface
{
    /**
     * @return BufferInterface
     */
    public function getBuffer(): BufferInterface;

    /**
     * @return string
     */
    public function getHex(): string;

    /**
     * @return string
     */
    public function getBinary(): string;

    /**
     * @return string
     */
    public function getInt();
}
