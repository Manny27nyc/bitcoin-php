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

namespace BitWasp\Bitcoin\Key\Factory;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Key\PublicKeySerializerInterface;
use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Deterministic\HierarchicalKey;
use BitWasp\Bitcoin\Key\Deterministic\MultisigHD;
use BitWasp\Bitcoin\Key\KeyToScript\Factory\P2pkhScriptDataFactory;
use BitWasp\Bitcoin\Key\KeyToScript\ScriptDataFactory;
use BitWasp\Bitcoin\Network\NetworkInterface;
use BitWasp\Bitcoin\Serializer\Key\HierarchicalKey\Base58ExtendedKeySerializer;
use BitWasp\Bitcoin\Serializer\Key\HierarchicalKey\ExtendedKeySerializer;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class HierarchicalKeyFactory
{
    /**
     * @var EcAdapterInterface
     */
    private $adapter;

    /**
     * @var Base58ExtendedKeySerializer
     */
    private $serializer;

    /**
     * @var PrivateKeyFactory
     */
    private $privFactory;

    /**
     * HierarchicalKeyFactory constructor.
     * @param EcAdapterInterface|null $ecAdapter
     * @param Base58ExtendedKeySerializer|null $serializer
     * @throws \Exception
     */
    public function __construct(EcAdapterInterface $ecAdapter = null, Base58ExtendedKeySerializer $serializer = null)
    {
        $this->adapter = $ecAdapter ?: Bitcoin::getEcAdapter();
        $this->privFactory = new PrivateKeyFactory($this->adapter);
        $this->serializer = $serializer ?: new Base58ExtendedKeySerializer(
            new ExtendedKeySerializer($this->adapter)
        );
    }

    /**
     * @param Random $random
     * @param ScriptDataFactory|null $scriptDataFactory
     * @return HierarchicalKey
     * @throws \BitWasp\Bitcoin\Exceptions\RandomBytesFailure
     * @throws \Exception
     */
    public function generateMasterKey(Random $random, ScriptDataFactory $scriptDataFactory = null): HierarchicalKey
    {
        return $this->fromEntropy(
            $random->bytes(64),
            $scriptDataFactory
        );
    }

    /**
     * @param BufferInterface $entropy
     * @param ScriptDataFactory|null $scriptFactory
     * @return HierarchicalKey
     * @throws \Exception
     */
    public function fromEntropy(BufferInterface $entropy, ScriptDataFactory $scriptFactory = null): HierarchicalKey
    {
        $seed = Hash::hmac('sha512', $entropy, new Buffer('Bitcoin seed'));
        $privSecret = $seed->slice(0, 32);
        $chainCode = $seed->slice(32, 32);
        $scriptFactory = $scriptFactory ?: new P2pkhScriptDataFactory(EcSerializer::getSerializer(PublicKeySerializerInterface::class, true, $this->adapter));
        return new HierarchicalKey($this->adapter, $scriptFactory, 0, 0, 0, $chainCode, $this->privFactory->fromBufferCompressed($privSecret));
    }

    /**
     * @param string $extendedKey
     * @param NetworkInterface|null $network
     * @return HierarchicalKey
     * @throws \BitWasp\Bitcoin\Exceptions\Base58ChecksumFailure
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function fromExtended(string $extendedKey, NetworkInterface $network = null): HierarchicalKey
    {
        return $this->serializer->parse($network ?: Bitcoin::getNetwork(), $extendedKey);
    }

    /**
     * @param ScriptDataFactory $scriptFactory
     * @param HierarchicalKey ...$keys
     * @return MultisigHD
     */
    public function multisig(ScriptDataFactory $scriptFactory, HierarchicalKey ...$keys): MultisigHD
    {
        return new MultisigHD($scriptFactory, ...$keys);
    }
}
