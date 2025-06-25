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

use BitWasp\Bitcoin\Transaction\TransactionFactory;

/**
 * This example reconstructs a transaction object from hex
 * 5c27196fc96f0db5499ee3c78466b4920c2ab13463793d3d32015ce32289131a
 */

$tx = TransactionFactory::fromHex("0100000001401cad87484eca06ce54bdbbc936aba4f5fd90e364120e628249f0f9c17f5be2010000006b483045022100d94b993d74c44439e3c83c6c6dd2a5a6d9765a3cb61c89fd7a2dc3e5d4e6a36b0220716f91456bf730eb0eddfa5f88ec5898f3fefcb311c688efacb728ff816c4ff1012102fbe61846a939936af3f8b05dbe237b9eddb9038fb195cc77433c28623c967abfffffffff02b8ab0000000000001976a914c05c2fd72090b06042377598c63af30d13a713a388acd29e0700000000001976a914b5a8a683e0f4f92fa2dc611b6d789cab964a104f88ac00000000");
echo $tx->getTxId()->getHex().PHP_EOL;
