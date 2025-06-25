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

namespace BitWasp\Bitcoin\Signature;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Buffertools\BufferInterface;

class SignatureSort implements SignatureSortInterface
{
    /**
     * @var EcAdapterInterface
     */
    private $ecAdapter;

    /**
     * SignatureSort constructor.
     * @param EcAdapterInterface $ecAdapter
     */
    public function __construct(EcAdapterInterface $ecAdapter = null)
    {
        $this->ecAdapter = $ecAdapter ?: Bitcoin::getEcAdapter();
    }

    /**
     * @param \BitWasp\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface[] $signatures
     * @param \BitWasp\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface[] $publicKeys
     * @param BufferInterface $messageHash
     * @return \SplObjectStorage
     */
    public function link(array $signatures, array $publicKeys, BufferInterface $messageHash): \SplObjectStorage
    {
        $sigCount = count($signatures);
        $storage = new \SplObjectStorage();
        foreach ($signatures as $signature) {
            foreach ($publicKeys as $key) {
                if ($key->verify($messageHash, $signature)) {
                    $storage->attach($key, $signature);
                    if (count($storage) === $sigCount) {
                        break 2;
                    }

                    break;
                }
            }
        }

        return $storage;
    }
}
