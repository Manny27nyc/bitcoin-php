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

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Deterministic\ElectrumKey;
use BitWasp\Bitcoin\Key\Factory\ElectrumKeyFactory;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Key\Factory\PublicKeyFactory;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class ElectrumKeyTest extends AbstractTestCase
{

    /**
     * @return array
     */
    public function getTestKeys()
    {
        $vectors = [
            [
                'teach start paradise collect blade chill gay childhood creek picture creator branch',
                '74b1f6c0caae485b4aeb2f26bab3cabdec4f0b432751bd454fe11b2d2907cbda',
                '819519e966729f31e1855eb75133d9e7f0c31abaadd8f184870d62771c62c2e759406ace1dee933095d15e4c719617e252f32dc0465393055f867aee9357cd52',
                [
                    // sequence number => address derived at that sequence
                    [0, '15ZL6i899dDBXm8NoXwn7oup4J5yQJi1NH'],
                    [1, '1FQS2H5mcgh1btw9oxxZs3onfEdvwAPPiP'],
                    [2, '1CBYszxw91ArPx8jHCD3jH8P8VwzeQdC2Z'],
                    [3, '1N9qHajqjoMpY9FnWzwEAsorUcmbdAjA2F']
                ]
            ]
        ];

        $data = [];
        foreach ($vectors as $vector) {
            foreach ($this->getEcAdapters() as $adapter) {
                $data[] = [
                    $adapter[0],
                    $vector[0],
                    $vector[1],
                    $vector[2],
                    $vector[3],
                ];
            }
        }

        return $data;
    }

    /**
     * @dataProvider getTestKeys
     * @param EcAdapterInterface $ecAdapter
     * @param string $mnemonic
     * @param string $eSecExp
     * @param string $eMPK
     * @param array $eAddrList
     */
    public function testCKD(EcAdapterInterface $ecAdapter, $mnemonic, $eSecExp, $eMPK, array $eAddrList = array())
    {
        $electrumFactory = new ElectrumKeyFactory($ecAdapter);
        $keyPriv = $electrumFactory->fromMnemonic($mnemonic);

        $keyPub = $keyPriv->withoutPrivateKey();
        $this->assertEquals($eSecExp, $keyPriv->getMasterPrivateKey()->getHex());
        $this->assertEquals($eMPK, $keyPriv->getMPK()->getHex());

        foreach ($eAddrList as $vector) {
            list ($sequence, $eAddr) = $vector;
            $childPriv = $keyPriv->deriveChild($sequence);
            $keyHash = $childPriv->getPubKeyHash();
            $this->assertEquals($eAddr, (new PayToPubKeyHashAddress($keyHash))->getAddress());

            $childPub = $keyPub->deriveChild($sequence);
            $keyHash = $childPub->getPubKeyHash();
            $this->assertEquals($eAddr, (new PayToPubKeyHashAddress($keyHash))->getAddress());
        }
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Electrum keys are not compressed
     */
    public function testFromKey()
    {
        $random = new Random();
        $privKeyFactory = new PrivateKeyFactory();
        $key = $privKeyFactory->generateUncompressed($random);

        $electrumFactory = new ElectrumKeyFactory();
        $e = $electrumFactory->fromKey($key);
        $this->assertInstanceOf(ElectrumKey::class, $e);

        $key = $privKeyFactory->generateCompressed($random);
        $electrumFactory->fromKey($key);
    }

    public function testGenerate()
    {
        $random = new Random();
        $bytes = $random->bytes(32);
        $electrumFactory = new ElectrumKeyFactory();
        $key = $electrumFactory->getKeyFromSeed($bytes);
        $this->assertInstanceOf(ElectrumKey::class, $key);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot produce master private key from master public key
     */
    public function testFailsWithoutMasterPrivateKey()
    {
        $pubKeyFactory = new PublicKeyFactory();
        $key = $pubKeyFactory->fromHex('045b81f0017e2091e2edcd5eecf10d5bdd120a5514cb3ee65b8447ec18bfc4575c6d5bf415e54e03b1067934a0f0ba76b01c6b9ab227142ee1d543764b69d901e0');
        $electrumFactory = new ElectrumKeyFactory();
        $e = $electrumFactory->fromKey($key);
        $e->getMasterPrivateKey();
    }
}
