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

namespace BitWasp\Bitcoin\Tests\Serializer\Transaction;

use BitWasp\Bitcoin\Serializer\Transaction\OutPointSerializer;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\OutPoint;
use BitWasp\Buffertools\Buffer;

class OutpointSerializerTest extends AbstractTestCase
{
    public function testOutpointSerializer()
    {
        $txid = new Buffer('a', 32);
        $vout = 10;
        $outpoint = new OutPoint($txid, $vout);

        $serialized = $txid->flip()->getBinary() . pack('V', $vout);
        $this->assertEquals($serialized, $outpoint->getBuffer()->getBinary());

        $serializer = new OutPointSerializer();
        $serializedOutput = $serializer->serialize($outpoint);
        $this->assertEquals($serialized, $serializedOutput->getBinary());

        $parsed = $serializer->parse($serializedOutput);
        $this->assertTrue($parsed->equals($outpoint));
    }
}
