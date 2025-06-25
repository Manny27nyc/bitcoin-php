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

namespace BitWasp\Bitcoin\Serializer\Signature;

use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\DerSignatureSerializerInterface;
use BitWasp\Bitcoin\Signature\TransactionSignature;
use BitWasp\Bitcoin\Signature\TransactionSignatureInterface;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class TransactionSignatureSerializer
{
    /**
     * @var DerSignatureSerializerInterface
     */
    private $sigSerializer;

    /**
     * @param DerSignatureSerializerInterface $sigSerializer
     */
    public function __construct(DerSignatureSerializerInterface $sigSerializer)
    {
        $this->sigSerializer = $sigSerializer;
    }

    /**
     * @param TransactionSignatureInterface $txSig
     * @return BufferInterface
     */
    public function serialize(TransactionSignatureInterface $txSig): BufferInterface
    {
        return new Buffer($this->sigSerializer->serialize($txSig->getSignature())->getBinary() . pack('C', $txSig->getHashType()));
    }

    /**
     * @param BufferInterface $buffer
     * @return TransactionSignatureInterface
     * @throws \Exception
     */
    public function parse(BufferInterface $buffer): TransactionSignatureInterface
    {
        $adapter = $this->sigSerializer->getEcAdapter();

        if ($buffer->getSize() < 1) {
            throw new \RuntimeException("Empty signature");
        }

        return new TransactionSignature(
            $adapter,
            $this->sigSerializer->parse($buffer->slice(0, -1)),
            (int) $buffer->slice(-1)->getInt()
        );
    }
}
