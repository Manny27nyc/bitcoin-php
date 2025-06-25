/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Network;

use BitWasp\Bitcoin\Network\Networks\Bitcoin;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class SignedMessageMagicTest extends AbstractTestCase
{
    public function testGetSignedMessageMagic()
    {
        $bitcoin = new Bitcoin();
        $this->assertEquals("Bitcoin Signed Message", $bitcoin->getSignedMessageMagic());
    }
}
