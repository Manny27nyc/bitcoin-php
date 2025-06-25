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

namespace BitWasp\Bitcoin\Tests\Key\Deterministic;

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\ScriptPrefix;
use BitWasp\Bitcoin\Key\Deterministic\Slip132\Slip132;
use BitWasp\Bitcoin\Key\Factory\HierarchicalKeyFactory;
use BitWasp\Bitcoin\Network\Slip132\BitcoinRegistry;
use BitWasp\Bitcoin\Key\KeyToScript\KeyToScriptHelper;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\Factory\Signer;
use BitWasp\Bitcoin\Transaction\Factory\TxBuilder;
use BitWasp\Bitcoin\Transaction\OutPoint;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Buffertools\Buffer;

class HierarchicalKeySignTest extends AbstractTestCase
{
    public function getEndToEndFixtures()
    {
        $fixtures = [];
        foreach ($this->getEcAdapters() as $adapterRow) {
            $adapter = $adapterRow[0];
            $slip132 = new Slip132(new KeyToScriptHelper($adapter));
            $registry = new BitcoinRegistry();
            $fixtures[] = [$adapter, $slip132->p2pkh($registry), 44];
            $fixtures[] = [$adapter, $slip132->p2shP2wpkh($registry), 49];
            $fixtures[] = [$adapter, $slip132->p2wpkh($registry), 84];
        }
        return $fixtures;
    }

    /**
     * @dataProvider getEndToEndFixtures
     * @param EcAdapterInterface $adapter
     * @param ScriptPrefix $prefix
     * @param int $purpose
     * @throws \Exception
     */
    public function testEndToEnd(EcAdapterInterface $adapter, ScriptPrefix $prefix, $purpose)
    {
        $hkFactory = new HierarchicalKeyFactory($adapter);
        $random = new Random();
        $key = $hkFactory->generateMasterKey($random, $prefix->getScriptDataFactory());
        $account = $key->derivePath("{$purpose}'/0'/0'");
        $external = $account->deriveChild(0);
        $key0 = $external->deriveChild(0);
        $key1 = $external->deriveChild(1);
        $key2 = $external->deriveChild(2);

        $spkAndData = $key0->getScriptAndSignData();
        $txOut = new TransactionOutput(
            12312312,
            $spkAndData->getScriptPubKey()
        );

        $outpoint = new OutPoint(Buffer::hex("79f20b268e5c7808e7df760151aa8e41d8f99280f96ad9c96b91df00a9bb5773"), 0);

        $txBuilder = new TxBuilder();
        $txBuilder->spendOutPoint($outpoint);
        $txBuilder->output(12000000, $key1->getScriptAndSignData()->getScriptPubKey());
        $txBuilder->output(302312, $key2->getScriptAndSignData()->getScriptPubKey());
        $unsigned = $txBuilder->get();

        $signer = new Signer($unsigned, $adapter);
        $input = $signer->input(0, $txOut, $spkAndData->getSignData());
        $input->sign($key0->getPrivateKey());
        $this->assertTrue($input->verify());
    }
}
