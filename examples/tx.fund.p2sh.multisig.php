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

require __DIR__ . "/../vendor/autoload.php";

use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Script\P2shScript;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Transaction\Factory\Signer;
use BitWasp\Bitcoin\Transaction\Factory\TxBuilder;
use BitWasp\Bitcoin\Transaction\OutPoint;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Buffertools\Buffer;

// Lets pretend the coins are owned by this guy
$privKeyFactory = new PrivateKeyFactory();
$originPriv = $privKeyFactory->fromWif("KzBmWku6EuUXbhSym74RXUE7bKWdNanc8vTqxFrMxEstofCWsKgH");
$originSpk = ScriptFactory::scriptPubKey()->p2pkh($originPriv->getPubKeyHash());

// 2 people want to receive BTC in a 2-of-2, so they contribute their
// public keys, and make a P2SH multisignature address
$privKey1 = $privKeyFactory->fromWif("L3WyxitKt4DQrhcdTEnyzLWWyurf2fz1iqCdAbuUXaUmSM328JWv");
$privKey2 = $privKeyFactory->fromWif("L45C3XqWziQVnifEQdzwYmpGG5SPXxFv5Es8bnjE5QXZF5K8bSGh");
$pubKeys = array_map(function (PrivateKeyInterface $priv) {
    return $priv->getPublicKey();
}, [$privKey1, $privKey2]);

// make a 2-of-2 multisignature script
$multisig = ScriptFactory::scriptPubKey()->multisig(2, $pubKeys);

// use the P2shScript 'decorator' to 'extend' script with extra
// functions relevant to a P2SH script
$p2shMultisig = new P2shScript($multisig);

// such as getOutputScript!
$scriptPubKey = $p2shMultisig->getOutputScript();

// some made up txid/outpoint for the test, but owned by originPriv
$outpoint = new OutPoint(Buffer::hex('a54255bc701c9746319b97d044bf90d4193d5f513de0fe759a1dff4e0c760155', 32), 0);
$txOut = new TransactionOutput(100000000, $originSpk);

$unsigned = (new TxBuilder())
    ->spendOutPoint($outpoint)
    ->output(95590000, $scriptPubKey)
    ->get();

$signer = new Signer($unsigned);
$input = $signer->input(0, $txOut);
$input->sign($originPriv);

// Check signatures
echo "Script validation result: " . ($input->verify() ? "yay\n" : "nay\n");

$signed = $signer->get();

echo $signed->getHex() . PHP_EOL;
echo "txid: {$signed->getTxId()->getHex()}\n";
