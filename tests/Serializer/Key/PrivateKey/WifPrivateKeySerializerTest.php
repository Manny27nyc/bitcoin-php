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

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Serializer\Key\PrivateKey;

use BitWasp\Bitcoin\Base58;
use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Key\PrivateKeySerializerInterface;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Serializer\Key\PrivateKey\WifPrivateKeySerializer;
use BitWasp\Bitcoin\Tests\Mnemonic\Bip39\AbstractBip39Case;
use BitWasp\Buffertools\Buffer;

class WifPrivateKeySerializerTest extends AbstractBip39Case
{
    /**
     * @param EcAdapterInterface $ecAdapter
     * @dataProvider getEcAdapters
     */
    public function testSerializer(EcAdapterInterface $ecAdapter)
    {
        $network = NetworkFactory::bitcoin();

        $hexSerializer = EcSerializer::getSerializer(PrivateKeySerializerInterface::class, true, $ecAdapter);
        $wifSerializer = new WifPrivateKeySerializer($hexSerializer);

        $factory = new PrivateKeyFactory($ecAdapter);
        $valid = $factory->generateUncompressed(new Random());
        $this->assertEquals($valid, $wifSerializer->parse($wifSerializer->serialize($network, $valid), $network));

        $invalid = Buffer::hex('8041414141414141414141414141414141');
        $b58 = Base58::encodeCheck($invalid);

        $this->expectException(\BitWasp\Bitcoin\Exceptions\InvalidPrivateKey::class);
        $this->expectExceptionMessage("Private key should be always be 32 or 33 bytes (depending on if it's compressed)");

        $wifSerializer->parse($b58);
    }
}
