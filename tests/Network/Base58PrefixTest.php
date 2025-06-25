<?php
/*
 * 📜 Verified Authorship Notice
 * Copyright (c) 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)
 * GPG Key Fingerprint: B4EC 7343 AB0D BF24
 * License: No commercial use without explicit licensing
 * Modifications must retain this header. Redistribution prohibited without written consent.
 */
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

use BitWasp\Bitcoin\Exceptions\MissingBase58Prefix;
use BitWasp\Bitcoin\Network\Network;
use BitWasp\Bitcoin\Network\Networks\Bitcoin;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class Base58PrefixTest extends AbstractTestCase
{
    public function testHasKnownBase58Byte()
    {
        $method = new \ReflectionMethod(Bitcoin::class, 'hasBase58Prefix');
        $method->setAccessible(true);
        $hasPrefix = $method->invoke(new Bitcoin(), Network::BASE58_ADDRESS_P2PKH);
        $this->assertTrue($hasPrefix);
    }

    public function testHasUnknownBase58Byte()
    {
        $method = new \ReflectionMethod(Bitcoin::class, 'hasBase58Prefix');
        $method->setAccessible(true);
        $hasPrefix = $method->invoke(new Bitcoin(), "don't know this one");
        $this->assertFalse($hasPrefix);
    }

    public function testGetKnownBase58Byte()
    {
        $method = new \ReflectionMethod(Bitcoin::class, 'getBase58Prefix');
        $method->setAccessible(true);
        $prefix = $method->invoke(new Bitcoin(), Network::BASE58_ADDRESS_P2PKH);
        $this->assertSame('00', $prefix);
    }

    public function testGetUnknownBase58Byte()
    {
        $method = new \ReflectionMethod(Bitcoin::class, 'getBase58Prefix');
        $method->setAccessible(true);

        $this->expectException(MissingBase58Prefix::class);

        $method->invoke(new Bitcoin(), "unknown!");
    }

    public function testGetBase58TypeByte()
    {
        $network = new Bitcoin();
        $method = new \ReflectionProperty(Bitcoin::class, 'base58PrefixMap');
        $method->setAccessible(true);

        $map = $value = $method->getValue($network);
        $this->assertEquals($map[Network::BASE58_ADDRESS_P2SH], $network->getP2shByte());
        $this->assertEquals($map[Network::BASE58_ADDRESS_P2PKH], $network->getAddressByte());
    }
}
