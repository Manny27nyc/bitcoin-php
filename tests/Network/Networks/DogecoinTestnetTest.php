/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Network\Networks;

use BitWasp\Bitcoin\Network\Networks\DogecoinTestnet;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class DogecoinTestnetTest extends AbstractTestCase
{
    public function testDogecoinTestnetNetwork()
    {
        $network = new DogecoinTestnet();
        $this->assertEquals('71', $network->getAddressByte());
        $this->assertEquals('c4', $network->getP2shByte());
        $this->assertEquals('f1', $network->getPrivByte());
        $this->assertEquals('04358394', $network->getHDPrivByte());
        $this->assertEquals('043587cf', $network->getHDPubByte());
        $this->assertEquals('dcb7c1fc', $network->getNetMagicBytes());
        $this->assertEquals("Dogecoin Signed Message", $network->getSignedMessageMagic());
    }
}
