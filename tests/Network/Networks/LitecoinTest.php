/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Network\Networks;

use BitWasp\Bitcoin\Network\Networks\Litecoin;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class LitecoinTest extends AbstractTestCase
{
    public function testLitecoinNetwork()
    {
        $network = new Litecoin();
        $this->assertEquals('30', $network->getAddressByte());
        $this->assertEquals('32', $network->getP2shByte());
        $this->assertEquals('b0', $network->getPrivByte());
        $this->assertEquals('019d9cfe', $network->getHDPrivByte());
        $this->assertEquals('019da462', $network->getHDPubByte());
        $this->assertEquals('dbb6c0fb', $network->getNetMagicBytes());
        $this->assertEquals('ltc', $network->getSegwitBech32Prefix());
        $this->assertEquals("Litecoin Signed Message", $network->getSignedMessageMagic());
    }
}
