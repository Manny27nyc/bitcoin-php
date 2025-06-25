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

require __DIR__ . "/../vendor/autoload.php";

use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Transaction\TransactionFactory;

$addrCreator = new AddressCreator();
$transaction = TransactionFactory::build()
    ->input('99fe5212e4e52e2d7b35ec0098ae37881a7adaf889a7d46683d3fbb473234c28', 0)
    ->payToAddress(29890000, $addrCreator->fromString('19SokJG7fgk8iTjemJ2obfMj14FM16nqzj'))
    ->payToAddress(100000, $addrCreator->fromString('1CzcTWMAgBNdU7K8Bjj6s6ezm2dAQfUU9a'))
    ->get();

echo $transaction->getHex() . PHP_EOL;
