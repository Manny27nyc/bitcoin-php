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

require __DIR__ . "/../../../vendor/autoload.php";

use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Transaction\OutPoint;

$outpoint1 = new OutPoint(
    Buffer::hex('87f7b7639d132e9817f58d3fe3f9f65ff317dc780107a6c10cba5ce2ad1e4ea1'),
    0
);

$outpoint2 = new OutPoint(
    Buffer::hex('87f7b7639d132e9817f58d3fe3f9f65ff317dc780107a6c10cba5ce2ad1e4ea1'),
    1
);

echo "outpoint1.txid: " . $outpoint1->getTxId()->getHex() . PHP_EOL;
echo "outpoint1.vout: " . $outpoint1->getVout() . PHP_EOL;
echo ($outpoint1->equals($outpoint2) ? "equals" : "not equal to") . " outpoint2\n";
