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

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\DerSignatureSerializerInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;
use BitWasp\Bitcoin\Exceptions\SignatureNotCanonical;
use BitWasp\Bitcoin\Serializable;
use BitWasp\Bitcoin\Serializer\Signature\TransactionSignatureSerializer;
use BitWasp\Buffertools\BufferInterface;

class TransactionSignature extends Serializable implements TransactionSignatureInterface
{
    /**
     * @var EcAdapterInterface
     */
    private $ecAdapter;

    /**
     * @var SignatureInterface
     */
    private $signature;

    /**
     * @var int
     */
    private $hashType;

    /**
     * @param EcAdapterInterface $ecAdapter
     * @param SignatureInterface $signature
     * @param int $hashType
     */
    public function __construct(EcAdapterInterface $ecAdapter, SignatureInterface $signature, int $hashType)
    {
        $this->ecAdapter = $ecAdapter;
        $this->signature = $signature;
        $this->hashType = $hashType;
    }

    /**
     * @return SignatureInterface
     */
    public function getSignature(): SignatureInterface
    {
        return $this->signature;
    }

    /**
     * @return int
     */
    public function getHashType(): int
    {
        return $this->hashType;
    }

    /**
     * @param TransactionSignatureInterface $other
     * @return bool
     */
    public function equals(TransactionSignatureInterface $other): bool
    {
        return $this->signature->equals($other->getSignature())
            && $this->hashType === $other->getHashType();
    }

    private static function verifyElement(string $fieldName, int $start, int $length, string $binaryString)
    {
        if ($length === 0) {
            throw new SignatureNotCanonical('Signature ' . $fieldName . ' length is zero');
        }
        $typePrefix = ord($binaryString[$start - 2]);
        if ($typePrefix !== 0x02) {
            throw new SignatureNotCanonical('Signature ' . $fieldName . ' value type mismatch');
        }

        $first = ord($binaryString[$start + 0]);
        if (($first & 0x80) === 128) {
            throw new SignatureNotCanonical('Signature ' . $fieldName . ' value is negative');
        }
        if ($length > 1 && $first === 0 && (ord($binaryString[$start + 1]) & 0x80) === 0) {
            throw new SignatureNotCanonical('Signature ' . $fieldName . ' value excessively padded');
        }
    }

    /**
     * @param BufferInterface $sig
     * @return bool
     * @throws SignatureNotCanonical
     */
    public static function isDERSignature(BufferInterface $sig): bool
    {
        $bin = $sig->getBinary();
        $size = $sig->getSize();
        if ($size < 9) {
            throw new SignatureNotCanonical('Signature too short');
        }

        if ($size > 73) {
            throw new SignatureNotCanonical('Signature too long');
        }

        if (ord($bin[0]) !== 0x30) {
            throw new SignatureNotCanonical('Signature has wrong type');
        }

        if (ord($bin[1]) !== $size - 3) {
            throw new SignatureNotCanonical('Signature has wrong length marker');
        }

        $lenR = ord($bin[3]);
        $startR = 4;
        if (5 + $lenR >= $size) {
            throw new SignatureNotCanonical('Signature S length misplaced');
        }

        $lenS = ord($bin[5 + $lenR]);
        $startS = 4 + $lenR + 2;
        if (($lenR + $lenS + 7) !== $size) {
            throw new SignatureNotCanonical('Signature R+S length mismatch');
        }

        self::verifyElement('R', $startR, $lenR, $bin);
        self::verifyElement('S', $startS, $lenS, $bin);

        return true;
    }

    /**
     * @return BufferInterface
     */
    public function getBuffer(): BufferInterface
    {
        $txSigSerializer = new TransactionSignatureSerializer(
            EcSerializer::getSerializer(DerSignatureSerializerInterface::class, true, $this->ecAdapter)
        );

        return $txSigSerializer->serialize($this);
    }
}
