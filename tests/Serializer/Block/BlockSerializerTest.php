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

namespace BitWasp\Bitcoin\Tests\Serializer\Block;

use BitWasp\Bitcoin\Math\Math;
use BitWasp\Bitcoin\Serializer\Block\BlockHeaderSerializer;
use BitWasp\Bitcoin\Serializer\Block\BlockSerializer;
use BitWasp\Bitcoin\Serializer\Transaction\TransactionSerializer;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class BlockSerializerTest extends AbstractTestCase
{
    /**
     * @expectedException \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function testInvalidParse()
    {
        $serializer = new BlockSerializer(
            new Math,
            new BlockHeaderSerializer,
            new TransactionSerializer()
        );
        $serializer->parse(new Buffer());
    }
}
