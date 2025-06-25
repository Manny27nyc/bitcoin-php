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

namespace BitWasp\Bitcoin\Key\Factory;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Key\KeyInterface;
use BitWasp\Bitcoin\Key\Deterministic\ElectrumKey;
use BitWasp\Bitcoin\Mnemonic\Electrum\ElectrumWordListInterface;
use BitWasp\Bitcoin\Mnemonic\MnemonicFactory;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class ElectrumKeyFactory
{
    /**
     * @var EcAdapterInterface
     */
    private $adapter;

    /**
     * @var PrivateKeyFactory
     */
    private $privateFactory;

    /**
     * ElectrumKeyFactory constructor.
     * @param EcAdapterInterface|null $ecAdapter
     */
    public function __construct(EcAdapterInterface $ecAdapter = null)
    {
        $this->adapter = $ecAdapter ?: Bitcoin::getEcAdapter();
        $this->privateFactory = new PrivateKeyFactory($ecAdapter);
    }

    /**
     * @param string $mnemonic
     * @param ElectrumWordListInterface $wordList
     * @return ElectrumKey
     * @throws \Exception
     */
    public function fromMnemonic(string $mnemonic, ElectrumWordListInterface $wordList = null): ElectrumKey
    {
        $mnemonicConverter = MnemonicFactory::electrum($wordList, $this->adapter);
        $entropy = $mnemonicConverter->mnemonicToEntropy($mnemonic);
        return $this->getKeyFromSeed($entropy);
    }

    /**
     * @param BufferInterface $seed
     * @return ElectrumKey
     * @throws \Exception
     */
    public function getKeyFromSeed(BufferInterface $seed): ElectrumKey
    {
        // Really weird, did electrum actually hash hex string seeds?
        $binary = $oldseed = $seed->getHex();

        // Perform sha256 hash 5 times per iteration
        for ($i = 0; $i < 5*20000; $i++) {
            // Hash should return binary data
            $binary = hash('sha256', $binary . $oldseed, true);
        }

        // Convert binary data to hex.
        $secretExponent = new Buffer($binary, 32);

        return $this->fromSecretExponent($secretExponent);
    }

    /**
     * @param BufferInterface $secret
     * @return ElectrumKey
     */
    public function fromSecretExponent(BufferInterface $secret): ElectrumKey
    {
        $masterKey = $this->privateFactory->fromBufferUncompressed($secret);
        return $this->fromKey($masterKey);
    }

    /**
     * @param KeyInterface $key
     * @return ElectrumKey
     */
    public function fromKey(KeyInterface $key): ElectrumKey
    {
        return new ElectrumKey($key);
    }
}
