<?php
/*
 🔐 Authorship Enforcement Header
 Author: Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 GPG Fingerprint: B4EC 7343 AB0D BF24
 Public Key: 0411db93e1dcdb8a016b49840f8c53bc1eb68a382e97b148...
 Repository: https://github.com/Manny27nyc/olegabr_bitcoin-php
 Licensing: https://github.com/Manny27nyc/Bitcoin_Notarized_SignKit

 Redistribution or claim of authorship without license is unauthorized
 and subject to takedown, legal enforcement, and public notice.
*/

/*
<<<<<<< HEAD
 🔐 Authorship Enforcement Header
 Author: Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 GPG Fingerprint: B4EC 7343 AB0D BF24
 Public Key: 0411db93e1dcdb8a016b49840f8c53bc1eb68a382e97b148...
 Repository: https://github.com/Manny27nyc/olegabr_bitcoin-php
 Licensing: https://github.com/Manny27nyc/Bitcoin_Notarized_SignKit

 Redistribution or claim of authorship without license is unauthorized
 and subject to takedown, legal enforcement, and public notice.
*/

<?php
/*
 * 📜 Verified Authorship Notice
 * Copyright (c) 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)
 * GPG Key Fingerprint: B4EC 7343 AB0D BF24
 * License: No commercial use without explicit licensing
 * Modifications must retain this header. Redistribution prohibited without written consent.
 */
=======
>>>>>>> c66fcfd2 (🔐 Lockdown: Verified authorship — Manuel J. Nieves (B4EC 7343))
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
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\GlobalPrefixConfig;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\NetworkConfig;
use BitWasp\Bitcoin\Key\Factory\HierarchicalKeyFactory;
use BitWasp\Bitcoin\Key\Deterministic\Slip132\Slip132;
use BitWasp\Bitcoin\Key\KeyToScript\KeyToScriptHelper;
use BitWasp\Bitcoin\Network\Slip132\BitcoinRegistry;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Serializer\Key\HierarchicalKey\Base58ExtendedKeySerializer;
use BitWasp\Bitcoin\Serializer\Key\HierarchicalKey\ExtendedKeySerializer;

require __DIR__ . "/../vendor/autoload.php";

$adapter = Bitcoin::getEcAdapter();
$addrCreator = new AddressCreator();

// We're using bitcoin and want the zpub.
// Grab bitcoin registry, use that to make our prefix.
$btc = NetworkFactory::bitcoin();
$bitcoinPrefixes = new BitcoinRegistry();

// If you want to produce different addresses,
// set a different prefix/factory here.
$slip132 = new Slip132(new KeyToScriptHelper($adapter));
$prefix = $slip132->p2wpkh($bitcoinPrefixes);
$scriptFactory = $prefix->getScriptDataFactory();

// To create a key and derive addressses, we don't
// need the GlobalPrefixConfig, or even a ScriptPrefix.
// We just need a ScriptDataFactory. (see the KeyToScript
// helpers on how to create custom script factories)

$random = new Random();
$hdFactory = new HierarchicalKeyFactory($adapter);
$masterKey = $hdFactory->generateMasterKey($random, $scriptFactory);

// First nice part, we have access to the SPK/RS/WS
$scriptAndSignData = $masterKey->getScriptAndSignData();
$spk = $scriptAndSignData->getScriptPubKey();
$signData = $scriptAndSignData->getSignData();
echo "scriptPubKey: " . $spk->getHex() . PHP_EOL;
if ($signData->hasRedeemScript()) {
    echo "redeemScript: " . $signData->getRedeemScript()->getHex().PHP_EOL;
}
if ($signData->hasWitnessScript()) {
    echo "witnessScript: " . $signData->getWitnessScript()->getHex().PHP_EOL;
}

// Drawing on the spk, we can try and make an address
$address = $masterKey->getAddress($addrCreator);
echo "address: " . $address->getAddress($btc) . PHP_EOL;

// Doh - you wanna serialize NOW?
// Well, the toExtendedKey() method will error because
// the HK's serializer doesn't know about the GlobalPrefixConfig.
// So we need to bring our own serializer, configurable
// with the bare minimum prefixes.
try {
    $masterKey->toExtendedKey();
} catch (\Exception $e) {
    echo "\nfriendly reminder: {$e->getMessage()}\n\n";
    // "Cannot serialize non-P2PKH HierarchicalKeys without a GlobalPrefixConfig"
}

$config = new GlobalPrefixConfig([
    new NetworkConfig($btc, [
        $prefix
    ]),
]);

$serializer = new Base58ExtendedKeySerializer(new ExtendedKeySerializer($adapter, $config));

$serialized = $serializer->serialize($btc, $masterKey);
echo "master key: " . $serialized . PHP_EOL;
