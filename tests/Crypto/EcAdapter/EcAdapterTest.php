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

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;
use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Crypto\Random\Rfc6979;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Key\Factory\PublicKeyFactory;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class EcAdapterTest extends AbstractTestCase
{
    /**
     * @return array
     */
    public function getPrivVectors()
    {
        $datasets = [];
        $data = json_decode($this->dataFile('privateKeys.json'), true);

        foreach ($data['vectors'] as $vector) {
            foreach ($this->getEcAdapters() as $adapter) {
                $datasets[] = [
                    $adapter[0],
                    $vector['priv'],
                    $vector['public'],
                    $vector['compressed']
                ];
            }
        }

        return $datasets;
    }

    /**
     * @dataProvider getPrivVectors
     * @param EcAdapterInterface $ec
     * @param string $privHex
     * @param string $pubHex
     * @param string $compressedHex
     * @throws \Exception
     */
    public function testPrivateToPublic(EcAdapterInterface $ec, $privHex, $pubHex, $compressedHex)
    {
        $ucFactory = new PrivateKeyFactory($ec);
        $priv = $ucFactory->fromHexUncompressed($privHex);
        $this->assertSame($priv->getPublicKey()->getHex(), $pubHex);
        $this->assertSame($privHex, $priv->getHex());

        $cFactory = new PrivateKeyFactory($ec);
        $priv = $cFactory->fromHexCompressed($privHex);
        $this->assertSame($compressedHex, $priv->getPublicKey()->getHex());
    }

    /**
     * @dataProvider getEcAdapters
     * @param EcAdapterInterface $ecAdapter
     */
    public function testIsValidKey(EcAdapterInterface $ecAdapter)
    {
        // Keys must be < the order of the curve
        // Order of secp256k1 - 1
        $valid = [
            'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFEBAAEDCE6AF48A03BBFD25E8CD0364140',
            '4141414141414141414141414141414141414141414141414141414141414141',
            '8000000000000000000000000000000000000000000000000000000000000000',
            '8000000000000000000000000000000000000000000000000000000000000001'
        ];

        foreach ($valid as $key) {
            $key = Buffer::hex($key);
            $this->assertTrue($ecAdapter->validatePrivateKey($key));
        }

        $invalid = [
            'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFEBAAEDCE6AF48A03BBFD25E8CD0364141',
            '0000000000000000000000000000000000000000000000000000000000000000'
        ];

        foreach ($invalid as $key) {
            $key = Buffer::hex($key, 32);
            $this->assertFalse($ecAdapter->validatePrivateKey($key));
        }
    }

    /**
     * @dataProvider getEcAdapters
     * @param EcAdapterInterface $ecAdapter
     */
    public function testIsValidPublicKey(EcAdapterInterface $ecAdapter)
    {
        $json = json_decode($this->dataFile('publickey.compressed.json'));
        $pubKeyFactory = new PublicKeyFactory($ecAdapter);
        foreach ($json->test as $test) {
            try {
                $pubKeyFactory->fromHex($test->compressed);
                $valid = true;
            } catch (\Exception $e) {
                $valid = false;
            }
            $this->assertTrue($valid);
        }
    }

    /**
     * @dataProvider getEcAdapters
     * @param EcAdapterInterface $ecAdapter
     */
    public function testDeterministicSign(EcAdapterInterface $ecAdapter)
    {
        $json = json_decode($this->dataFile('hmacdrbg.json'));
        $math = $ecAdapter->getMath();
        $privKeyFactory = new PrivateKeyFactory($ecAdapter);
        foreach ($json->test as $c => $test) {
            $privateKey = $privKeyFactory->fromHexUncompressed($test->privKey);
            $message = new Buffer($test->message, null);
            $messageHash = Hash::sha256($message);

            $k = new Rfc6979($ecAdapter, $privateKey, $messageHash);
            $sig = $privateKey->sign($messageHash, $k);

            // K must be correct (from privatekey and message hash)
            $this->assertEquals(strtolower($test->expectedK), $k->bytes(32)->getHex());

            // R and S should be correct
            $rHex = $math->decHex(gmp_strval($sig->getR(), 10));
            $sHex = $math->decHex(gmp_strval($sig->getS(), 10));
            $this->assertSame($test->expectedRSLow, $rHex . $sHex);

            $this->assertTrue($privateKey->getPublicKey()->verify($messageHash, $sig));
        }
    }

    /**
     * @dataProvider getEcAdapters
     * @param EcAdapterInterface $ecAdapter
     */
    public function testPrivateKeySign(EcAdapterInterface $ecAdapter)
    {
        $random = new Random();
        $pk = $ecAdapter->getPrivateKey(gmp_init('4141414141414141414141414141414141414141414141414141414141414141'), false);

        $hash = $random->bytes(32);
        $sig = $pk->sign($hash, new Random());

        $this->assertInstanceOf(SignatureInterface::class, $sig);
        $this->assertTrue($pk->getPublicKey()->verify($hash, $sig));
    }
}
