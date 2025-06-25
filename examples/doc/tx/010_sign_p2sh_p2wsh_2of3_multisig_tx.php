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

use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Key\Factory\PublicKeyFactory;
use BitWasp\Bitcoin\Script\Interpreter\Interpreter;
use BitWasp\Bitcoin\Script\P2shScript;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\WitnessScript;
use BitWasp\Bitcoin\Transaction\Factory\SignData;
use BitWasp\Bitcoin\Transaction\Factory\Signer;
use BitWasp\Bitcoin\Transaction\TransactionFactory;
use BitWasp\Bitcoin\Transaction\TransactionOutput;

require __DIR__ . "/../../../vendor/autoload.php";

/**
 * This example shows a 2-of-2 P2WSH multisig
 * output being spent, sending some to another
 * address, and the rest to our own address again (the change)
 *
 * We use the WitnessScript to decorate the multisig
 * script so we can create the output script/address
 * easily.
 *
 * The witnessScript is assigned to a SignData instance
 * because the unsigned transaction doesn't have the
 * witnessScript yet.
 */
$privKeyFactory = new PrivateKeyFactory();
$pubKeyFactory = new PublicKeyFactory();
$privateKey1 = $privKeyFactory->fromHexCompressed('7bca8cbb9e0c108445281ade9d8f6b7d8bb18edb0b5ca4dc3aa660362b96f831', true);
$publicKey1 = $privateKey1->getPublicKey();

$publicKey2 = $pubKeyFactory->fromHex("03fff6dc247b15006cb88ad4d052f303e063ac88e99c3eb98b2d20aa9328943cd9");

$privateKey3 = $privKeyFactory->fromHexCompressed("108445281ade9d8f6b7d8bb1825ca40bedb67bca8cdc3aa6603b9b6f831b9e0c", true);
$publicKey3 = $privateKey3->getPublicKey();

// The witnessScript needs to be known when spending
$witnessScript = new WitnessScript(
    ScriptFactory::scriptPubKey()->multisig(2, [$publicKey1, $publicKey2, $publicKey3])
);

$redeemScript = new P2shScript($witnessScript);
$spendFromAddress = $redeemScript->getAddress();

$sendToAddress = (new AddressCreator())->fromString('1DUzqgG31FvNubNL6N1FVdzPbKYWZG2Mb6');
echo "Spend from {$spendFromAddress->getAddress()}\n";
echo "Send to {$sendToAddress->getAddress()}\n";

$addressCreator = new AddressCreator();
$transaction = TransactionFactory::build()
    ->input('87f7b7639d132e9817f58d3fe3f9f65ff317dc780107a6c10cba5ce2ad1e4ea1', 0)
    ->payToAddress(200000000, $sendToAddress)
    ->payToAddress(290000000, $spendFromAddress) // don't forget your change output!
    ->get();

$txOut = new TransactionOutput(500000000, $redeemScript->getOutputScript());
$signData = (new SignData())
    ->p2sh($redeemScript)
    ->p2wsh($witnessScript)
;

$signer = new Signer($transaction);
$input = $signer->input(0, $txOut, $signData);
$input->sign($privateKey1);
$input->sign($privateKey3);

$signed = $signer->get();

echo "txid: {$signed->getTxId()->getHex()}\n";
echo "raw: {$signed->getHex()}\n";
echo "ws: {$witnessScript->getHex()}\n";
echo "input valid? " . ($input->verify(Interpreter::VERIFY_DERSIG | Interpreter::VERIFY_P2SH | Interpreter::VERIFY_WITNESS) ? "true" : "false") . PHP_EOL;
