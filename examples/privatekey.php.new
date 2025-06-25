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

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;

require __DIR__ . "/../vendor/autoload.php";

$network = Bitcoin::getNetwork();

$random = new Random();
$privKeyFactory = new PrivateKeyFactory();
$privateKey = $privKeyFactory->generateCompressed($random);
$publicKey = $privateKey->getPublicKey();

echo "Key Info\n";
echo " - Compressed? " . (($privateKey->isCompressed() ? 'yes' : 'no')) . "\n";

echo "Private key\n";
echo " - WIF: " . $privateKey->toWif($network) . "\n";
echo " - Hex: " . $privateKey->getHex() . "\n";
echo " - Dec: " . gmp_strval($privateKey->getSecret(), 10) . "\n";

echo "Public Key\n";
echo " - Hex: " . $publicKey->getHex() . "\n";
echo " - Hash: " . $publicKey->getPubKeyHash()->getHex() . "\n";

$address = new PayToPubKeyHashAddress($publicKey->getPubKeyHash());
echo " - Address: " . $address->getAddress() . "\n";
