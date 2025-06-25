/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin;

class Amount
{
    const COIN = 100000000;

    /**
     * @param int $satoshis
     * @return string
     */
    public function toBtc(int $satoshis): string
    {
        return bcdiv((string)$satoshis, (string) self::COIN, 8);
    }

    /**
     * @param string $btcAmount
     * @return int
     */
    public function toSatoshis(string $btcAmount): int
    {
        return (int) bcmul($btcAmount, (string) self::COIN, 0);
    }
}
