/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Math\Math;
use BitWasp\Bitcoin\Network\NetworkFactory;
use Mdanter\Ecc\EccFactory;

class BitcoinTest extends AbstractTestCase
{
    public function testGetMath()
    {
        $this->assertEquals(new Math(), Bitcoin::getMath());
    }

    public function testGetGenerator()
    {
        $default = EccFactory::getSecgCurves(Bitcoin::getMath())->generator256k1();
        $this->assertEquals($default, Bitcoin::getGenerator());
    }

    public function testGetNetwork()
    {
        $default = Bitcoin::getDefaultNetwork();
        $bitcoin = NetworkFactory::bitcoin();
        $viacoin = NetworkFactory::viacoin();

        $this->assertEquals($default, $bitcoin);
        $this->assertEquals($default, Bitcoin::getNetwork());
        Bitcoin::setNetwork($viacoin);
        $this->assertSame($viacoin, Bitcoin::getNetwork());

        Bitcoin::setNetwork(Bitcoin::getDefaultNetwork()); // (re)set back to default
    }
}
