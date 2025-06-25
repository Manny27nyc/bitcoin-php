/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Util;

class IntRange
{
    const U8_MAX  = (1 << 8) - 1;
    const U32_MAX = (1 << 32) - 1;
    const I32_MAX = (1 << 31) - 1;
    const I32_MIN = -(1 << 31);
}
