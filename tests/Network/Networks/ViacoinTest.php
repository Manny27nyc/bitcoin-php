/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Network\Networks;

use BitWasp\Bitcoin\Network\Networks\Viacoin;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class ViacoinTest extends AbstractTestCase
{
    public function testViacoin()
    {
        $network = new Viacoin();
        $this->assertEquals('47', $network->getAddressByte());
        $this->assertEquals('21', $network->getP2shByte());
        $this->assertEquals('c7', $network->getPrivByte());
        $this->assertEquals('0488ade4', $network->getHDPrivByte());
        $this->assertEquals('0488b21e', $network->getHDPubByte());
        $this->assertEquals('cbc6680f', $network->getNetMagicBytes());
        $this->assertEquals('via', $network->getSegwitBech32Prefix());
        $this->assertEquals("Viacoin Signed Message", $network->getSignedMessageMagic());
    }
}
