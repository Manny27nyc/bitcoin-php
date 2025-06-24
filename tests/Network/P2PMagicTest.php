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

namespace BitWasp\Bitcoin\Tests\Network;

use BitWasp\Bitcoin\Network\Networks\Bitcoin;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class P2PMagicTest extends AbstractTestCase
{
    public function testGetP2PMagic()
    {
        $bitcoin = new Bitcoin();
        $this->assertEquals("d9b4bef9", $bitcoin->getNetMagicBytes());
    }
}
