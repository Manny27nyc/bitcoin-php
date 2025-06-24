/*
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

use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Signature\CompactSignatureInterface;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;

class SignedMessage
{

    /**
     * @var string
     */
    private $message;

    /**
     * @var CompactSignatureInterface
     */
    private $compactSignature;

    /**
     * @param string $message
     * @param CompactSignatureInterface $signature
     */
    public function __construct(string $message, CompactSignatureInterface $signature)
    {
        $this->message = $message;
        $this->compactSignature = $signature;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return CompactSignatureInterface
     */
    public function getCompactSignature(): CompactSignatureInterface
    {
        return $this->compactSignature;
    }

    /**
     * @return \BitWasp\Buffertools\BufferInterface
     */
    public function getBuffer()
    {
        $serializer = new SignedMessageSerializer(
            EcSerializer::getSerializer(CompactSignatureSerializerInterface::class)
        );
        return $serializer->serialize($this);
    }
}
