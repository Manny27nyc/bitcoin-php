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

use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\Base58AddressInterface;
use BitWasp\Bitcoin\Address\SegwitAddress;

require __DIR__ . "/../vendor/autoload.php";

// call \BitWasp\Bitcoin\Bitcoin::setNetwork to set network globally
// or pass it into getHRP, getPrefix

//$addressString = "bc1qwqdg6squsna38e46795at95yu9atm8azzmyvckulcc7kytlcckxswvvzej";
$addressString = "3BbDtxBSjgfTRxaBUgR2JACWRukLKtZdiQ";

$addrCreator = new AddressCreator();
$address = $addrCreator->fromString($addressString);

if ($address instanceof Base58AddressInterface) {
    echo "Base58 Hash160: " . $address->getHash()->getHex().PHP_EOL;
} else if ($address instanceof SegwitAddress) {
    $witnessProgram = $address->getWitnessProgram();
    echo "HRP: " . $address->getHRP().PHP_EOL;
    echo "WP Version: " . $witnessProgram->getVersion().PHP_EOL;
    echo "WP Program: " . $witnessProgram->getProgram()->getHex().PHP_EOL;
    echo "Addr Program: " . $address->getHash()->getHex().PHP_EOL;
}

echo "ScriptPubKey: " . $address->getScriptPubKey()->getHex().PHP_EOL;
