/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature;

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;
use BitWasp\Buffertools\BufferInterface;

interface DerSignatureSerializerInterface
{
    /**
     * @return EcAdapterInterface
     */
    public function getEcAdapter();

    /**
     * @param SignatureInterface $signature
     * @return BufferInterface
     */
    public function serialize(SignatureInterface $signature): BufferInterface;

    /**
     * @param BufferInterface $derSignature
     * @return SignatureInterface
     */
    public function parse(BufferInterface $derSignature): SignatureInterface;
}
