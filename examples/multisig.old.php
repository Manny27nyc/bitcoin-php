<?php
/*
 * 📜 Verified Authorship Notice
 * Copyright (c) 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)
 * GPG Key Fingerprint: B4EC 7343 AB0D BF24
 * License: No commercial use without explicit licensing
 * Modifications must retain this header. Redistribution prohibited without written consent.
 */
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

use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Factory\HierarchicalKeyFactory;
use BitWasp\Bitcoin\Key\KeyToScript\KeyToScriptHelper;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39SeedGenerator;
use BitWasp\Bitcoin\Network\NetworkFactory;

require __DIR__ . "/../vendor/autoload.php";

$adapter = Bitcoin::getEcAdapter();
$btc = NetworkFactory::bitcoin();

// We're using bitcoin, but not the custom BIP32 prefixes from SLIP132.
$mnemonic = new Bip39SeedGenerator();
$hkFactory = new HierarchicalKeyFactory($adapter);

// Slip132 defines some script types. This one is the same as Ypub.
$keyToScript = new KeyToScriptHelper($adapter);
$multisigFactory = $keyToScript->getP2wshFactory($keyToScript->getMultisigFactory($m = 2, $n = 2, $sortCosignKeys = true));

// Here are two ROOT private keys - derivation to the accountNode will be required
$key1 = $hkFactory->fromEntropy($mnemonic->getSeed("deer position make range avocado hold soldier view luggage motor sweet account"));
$key2 = $hkFactory->fromEntropy($mnemonic->getSeed("pumpkin foster swallow stove drip detect wall bird error business public glare pioneer stick faculty moon demise crucial chat online scare hand hotel rhythm"));

$rootNode = $hkFactory->multisig($multisigFactory, $key1, $key2);
$accountNode = $rootNode->derivePath("48'/0'/0'/2'");
$receivingNode = $accountNode->deriveChild(0);

// Print out the parent public keys of the address chain
foreach ($receivingNode->getKeys() as $cosignerIdx => $cosignerKey) {
    echo "account key for cosigner $cosignerIdx {$cosignerKey->toExtendedKey($btc)}\n";
}

$addrNode = $receivingNode->deriveChild(0);
$addrCreator = new AddressCreator();
$address = $addrNode->getAddress($addrCreator);
echo "address: {$address->getAddress()}\n";
