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

namespace BitWasp\Bitcoin\Tests\Network\Slip132;

use BitWasp\Bitcoin\Network\Networks\Bitcoin;
use BitWasp\Bitcoin\Network\Slip132\BitcoinRegistry;
use BitWasp\Bitcoin\Script\ScriptType;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class BitcoinRegistryTest extends AbstractTestCase
{
    /**
     * @throws \BitWasp\Bitcoin\Exceptions\InvalidNetworkParameter
     * @throws \BitWasp\Bitcoin\Exceptions\MissingBip32Prefix
     */
    public function testXpubP2pkh()
    {
        $network = new Bitcoin();
        $registry = new BitcoinRegistry();
        list ($priv, $pub) = $registry->getPrefixes(ScriptType::P2PKH);

        $this->assertEquals(
            $network->getHDPubByte(),
            $pub
        );

        $this->assertEquals(
            $network->getHDPrivByte(),
            $priv
        );
    }
    /**
     * @throws \BitWasp\Bitcoin\Exceptions\InvalidNetworkParameter
     * @throws \BitWasp\Bitcoin\Exceptions\MissingBip32Prefix
     */
    public function testXpubP2shMultisig()
    {
        $network = new Bitcoin();
        $registry = new BitcoinRegistry();
        list ($priv, $pub) = $registry->getPrefixes(ScriptType::P2SH . "|" . ScriptType::MULTISIG);

        $this->assertEquals(
            $network->getHDPubByte(),
            $pub
        );

        $this->assertEquals(
            $network->getHDPrivByte(),
            $priv
        );
    }

    public function testypubP2shP2wpkh()
    {
        $registry = new BitcoinRegistry();
        list ($priv, $pub) = $registry->getPrefixes(ScriptType::P2SH . "|" . ScriptType::P2WKH);

        $this->assertEquals("049d7cb2", $pub);
        $this->assertEquals("049d7878", $priv);
    }

    public function testYpubP2shP2wshP2pkh()
    {
        $registry = new BitcoinRegistry();
        list ($priv, $pub) = $registry->getPrefixes(ScriptType::P2SH . "|" . ScriptType::P2WSH . "|" . ScriptType::MULTISIG);

        $this->assertEquals("0295b43f", $pub);
        $this->assertEquals("0295b005", $priv);
    }

    public function testzpubP2wpkh()
    {
        $registry = new BitcoinRegistry();
        list ($priv, $pub) = $registry->getPrefixes(ScriptType::P2WKH);

        $this->assertEquals("04b24746", $pub);
        $this->assertEquals("04b2430c", $priv);
    }

    public function testZpubP2wshP2pkh()
    {
        $registry = new BitcoinRegistry();
        list ($priv, $pub) = $registry->getPrefixes(ScriptType::P2WSH . "|" . ScriptType::MULTISIG);

        $this->assertEquals("02aa7ed3", $pub);
        $this->assertEquals("02aa7a99", $priv);
    }
}
