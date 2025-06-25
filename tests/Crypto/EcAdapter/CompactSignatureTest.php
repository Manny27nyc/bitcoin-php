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

namespace BitWasp\Bitcoin\Tests\Crypto\EcAdapter;

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class CompactSignatureTest extends AbstractTestCase
{
    /**
     * @return array
     */
    public function getCSVectors()
    {
        // create identical test vectors for secp256k1 and phpecc
        // Note that signatures should mean the verifying party can recover the correct pubkey, so the effects of
        // signing with a compressed/uncompressed key need to be tested (so that correct pubkey form is found, so the
        // correct address can be found)

        $vectors = [];

        $random = new Random();
        for ($i = 0; $i < 2; $i++) {
            ;
            $message = "Message $i";

            foreach ($this->getEcAdapters() as $adapterRow) {
                $adapter = $adapterRow[0];
                $keyFactory = new PrivateKeyFactory($adapter);

                $priv = $keyFactory->generateUncompressed($random)->getHex();

                $vectors[] = [$adapter, $keyFactory->fromHexCompressed($priv), $message];
                $vectors[] = [$adapter, $keyFactory->fromHexUncompressed($priv), $message];
            }
        }

        return $vectors;
    }

    /**
     * @dataProvider getCSVectors
     * @param EcAdapterInterface $ecAdapter
     * @param PrivateKeyInterface $private
     * @param string $message
     */
    public function testCompactSignature(EcAdapterInterface $ecAdapter, PrivateKeyInterface $private, string $message)
    {
        $pubKey = $private->getPublicKey();
        $msgSigner = new MessageSigner($ecAdapter);
        $signed = $msgSigner->sign($message, $private);
        $compact = $signed->getCompactSignature();

        $this->assertEquals(65, $compact->getBuffer()->getSize());
        $this->assertTrue($msgSigner->verify($signed, new PayToPubKeyHashAddress($pubKey->getPubKeyHash())));

        /** @var CompactSignatureSerializerInterface $serializer */
        $serializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class, true, $ecAdapter);

        $parsed = $serializer->parse($compact->getBuffer());
        $this->assertEquals($compact->getBinary(), $parsed->getBinary());
    }
}
