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

namespace BitWasp\Bitcoin\Tests\Network\Networks;

use BitWasp\Bitcoin\Network\Networks\Dogecoin;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class DogecoinTest extends AbstractTestCase
{
    public function testDogecoinNetwork()
    {
        $network = new Dogecoin();
        $this->assertEquals('1e', $network->getAddressByte());
        $this->assertEquals('16', $network->getP2shByte());
        $this->assertEquals('9e', $network->getPrivByte());
        $this->assertEquals('02fac398', $network->getHDPrivByte());
        $this->assertEquals('02facafd', $network->getHDPubByte());
        $this->assertEquals('c0c0c0c0', $network->getNetMagicBytes());
        $this->assertEquals("Dogecoin Signed Message", $network->getSignedMessageMagic());
    }
}
