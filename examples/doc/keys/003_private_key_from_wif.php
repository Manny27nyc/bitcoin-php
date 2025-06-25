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

require __DIR__ . "/../../../vendor/autoload.php";

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Address\SegwitAddress;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Script\WitnessProgram;

$privKeyFactory = new PrivateKeyFactory();

$rbg = new Random();
$privateKey = $privKeyFactory->fromWif("L2uRfwpmG3RTXTy6ZvzTRC4Xtkwi6axoQFopgRsCEpsSc5Qh5uSP");
$publicKey = $privateKey->getPublicKey();
echo "private key wif  {$privateKey->toWif()}\n";
echo "            hex  {$privateKey->getHex()}\n";
echo "compressed       ".($privateKey->isCompressed()?"true":"false").PHP_EOL;
echo "public key  hex  {$publicKey->getHex()}\n";

$pubKeyHash160 = $publicKey->getPubKeyHash();
$pubKeyHashAddr = new PayToPubKeyHashAddress($pubKeyHash160);
echo "p2pkh address    {$pubKeyHashAddr->getAddress()}\n";

$witnessPubKeyHashAddr = new SegwitAddress(WitnessProgram::v0($pubKeyHash160));
echo "p2wpkh address   {$witnessPubKeyHashAddr->getAddress()}\n";
