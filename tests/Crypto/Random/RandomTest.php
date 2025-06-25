/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Crypto\Random;

use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class RandomTest extends AbstractTestCase
{
    public function testBytes()
    {
        $random = new Random();
        $bytes  = $random->bytes(32);
        $this->assertInstanceOf(Buffer::class, $bytes);
        $this->assertEquals(32, $bytes->getSize());
    }
}
