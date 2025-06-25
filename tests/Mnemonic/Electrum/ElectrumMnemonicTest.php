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

namespace BitWasp\Bitcoin\Tests\Mnemonic\Electrum;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Mnemonic\Electrum\ElectrumMnemonic;
use BitWasp\Bitcoin\Mnemonic\Electrum\Wordlist\EnglishWordList;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class ElectrumMnemonicTest extends AbstractTestCase
{
    public function testSpecificMnemonic()
    {
        $ec = Bitcoin::getEcAdapter();
        $mnemonicConv = new ElectrumMnemonic($ec, new EnglishWordList());

        $mnemonic = trim('teach start paradise collect blade chill gay childhood creek picture creator branch');
        $known_seed = 'dcb85458ec2fcaaac54b71fba90bd4a5';

        $this->assertEquals($known_seed, $mnemonicConv->mnemonicToEntropy($mnemonic)->getHex());
    }

    public function testEncodesEntropy()
    {
        $ec = Bitcoin::getEcAdapter();
        $m = new ElectrumMnemonic($ec, new EnglishWordList());

        $random = new Random();
        $bytes = $random->bytes(16);
        $words = $m->entropyToMnemonic($bytes);
        $entropy = $m->mnemonicToEntropy($words);

        $this->assertEquals($bytes, $entropy);
    }
}
