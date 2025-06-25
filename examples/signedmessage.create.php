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

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;

$ec = Bitcoin::getEcAdapter();
$random = new Random();
$privKeyFactory = new PrivateKeyFactory($ec);
$privateKey = $privKeyFactory->generateCompressed($random);

$message = 'hi';

$signer = new MessageSigner($ec);
$signed = $signer->sign($message, $privateKey);
$address = new PayToPubKeyHashAddress($privateKey->getPublicKey()->getPubKeyHash());
echo sprintf("Signed by %s\n%s\n", $address->getAddress(), $signed->getBuffer()->getBinary());
