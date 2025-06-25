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

require_once __DIR__ . "/../vendor/autoload.php";

use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\HierarchicalKeyFactory;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39Mnemonic;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39SeedGenerator;
use BitWasp\Bitcoin\Mnemonic\MnemonicFactory;

// Generate a mnemonic
$random = new Random();
$entropy = $random->bytes(Bip39Mnemonic::MAX_ENTROPY_BYTE_LEN);

$bip39 = MnemonicFactory::bip39();
$seedGenerator = new Bip39SeedGenerator();
$mnemonic = $bip39->entropyToMnemonic($entropy);

// Derive a seed from mnemonic/password
$seed = $seedGenerator->getSeed($mnemonic, 'password');
echo $seed->getHex() . "\n";

$hdFactory = new HierarchicalKeyFactory();
$bip32 = $hdFactory->fromEntropy($seed);
