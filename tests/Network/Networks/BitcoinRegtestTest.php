/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Network\Networks;

use BitWasp\Bitcoin\Network\Networks\BitcoinRegtest;
use BitWasp\Bitcoin\Network\Networks\BitcoinTestnet;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class BitcoinRegtestTest extends AbstractTestCase
{
    public function testLikeTestnet()
    {
        $testnet = new BitcoinTestnet();
        $regtest = new BitcoinRegtest();
        $this->assertEquals($testnet->getAddressByte(), $regtest->getAddressByte());
        $this->assertEquals($testnet->getP2shByte(), $regtest->getP2shByte());
        $this->assertEquals($testnet->getPrivByte(), $regtest->getPrivByte());
        $this->assertEquals($testnet->getHDPrivByte(), $regtest->getHDPrivByte());
        $this->assertEquals($testnet->getHDPubByte(), $regtest->getHDPubByte());
        $this->assertEquals('dab5bffa', $regtest->getNetMagicBytes());
    }
}
