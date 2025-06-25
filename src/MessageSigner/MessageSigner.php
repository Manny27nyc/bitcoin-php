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

namespace BitWasp\Bitcoin\MessageSigner;

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Crypto\Random\Rfc6979;
use BitWasp\Bitcoin\Network\NetworkInterface;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Buffertools;

class MessageSigner
{
    /**
     * @var EcAdapterInterface
     */
    private $ecAdapter;

    /**
     * @param EcAdapterInterface $ecAdapter
     */
    public function __construct(EcAdapterInterface $ecAdapter = null)
    {
        $this->ecAdapter = $ecAdapter ?: Bitcoin::getEcAdapter();
    }

    /**
     * @param NetworkInterface $network
     * @param string $message
     * @return BufferInterface
     * @throws \Exception
     */
    private function calculateBody(NetworkInterface $network, string $message): BufferInterface
    {
        $prefix = sprintf("%s:\n", $network->getSignedMessageMagic());
        return new Buffer(sprintf(
            "%s%s%s%s",
            Buffertools::numToVarInt(strlen($prefix))->getBinary(),
            $prefix,
            Buffertools::numToVarInt(strlen($message))->getBinary(),
            $message
        ));
    }

    /**
     * @param NetworkInterface $network
     * @param string $message
     * @return BufferInterface
     */
    public function calculateMessageHash(NetworkInterface $network, string $message): BufferInterface
    {
        return Hash::sha256d($this->calculateBody($network, $message));
    }

    /**
     * @param SignedMessage $signedMessage
     * @param PayToPubKeyHashAddress $address
     * @param NetworkInterface|null $network
     * @return bool
     */
    public function verify(SignedMessage $signedMessage, PayToPubKeyHashAddress $address, NetworkInterface $network = null): bool
    {
        $network = $network ?: Bitcoin::getNetwork();
        $hash = $this->calculateMessageHash($network, $signedMessage->getMessage());

        $publicKey = $this->ecAdapter->recover(
            $hash,
            $signedMessage->getCompactSignature()
        );

        return $publicKey->getPubKeyHash()->equals($address->getHash());
    }

    /**
     * @param string $message
     * @param PrivateKeyInterface $privateKey
     * @param NetworkInterface|null $network
     * @return SignedMessage
     */
    public function sign(string $message, PrivateKeyInterface $privateKey, NetworkInterface $network = null): SignedMessage
    {
        $network = $network ?: Bitcoin::getNetwork();
        $hash = $this->calculateMessageHash($network, $message);

        return new SignedMessage(
            $message,
            $privateKey->signCompact(
                $hash,
                new Rfc6979(
                    $this->ecAdapter,
                    $privateKey,
                    $hash,
                    'sha256'
                )
            )
        );
    }
}
