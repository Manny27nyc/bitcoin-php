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

namespace BitWasp\Bitcoin\Mnemonic\Bip39;

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Mnemonic\MnemonicInterface;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class Bip39Mnemonic implements MnemonicInterface
{
    /**
     * @var EcAdapterInterface
     */
    private $ecAdapter;

    /**
     * @var Bip39WordListInterface
     */
    private $wordList;

    const MIN_ENTROPY_BYTE_LEN = 16;
    const MAX_ENTROPY_BYTE_LEN = 32;
    const DEFAULT_ENTROPY_BYTE_LEN = self::MAX_ENTROPY_BYTE_LEN;

    private $validEntropySizes = [
        self::MIN_ENTROPY_BYTE_LEN * 8, 160, 192, 224, self::MAX_ENTROPY_BYTE_LEN * 8,
    ];

    /**
     * @param EcAdapterInterface $ecAdapter
     * @param Bip39WordListInterface $wordList
     */
    public function __construct(EcAdapterInterface $ecAdapter, Bip39WordListInterface $wordList)
    {
        $this->ecAdapter = $ecAdapter;
        $this->wordList = $wordList;
    }

    /**
     * Creates a new Bip39 mnemonic string.
     *
     * @param int $entropySize
     * @return string
     * @throws \BitWasp\Bitcoin\Exceptions\RandomBytesFailure
     */
    public function create(int $entropySize = null): string
    {
        if (null === $entropySize) {
            $entropySize = self::DEFAULT_ENTROPY_BYTE_LEN * 8;
        }

        if (!in_array($entropySize, $this->validEntropySizes)) {
            throw new \InvalidArgumentException("Invalid entropy length");
        }

        $random = new Random();
        $entropy = $random->bytes($entropySize / 8);

        return $this->entropyToMnemonic($entropy);
    }

    /**
     * @param BufferInterface $entropy
     * @param integer $CSlen
     * @return string
     */
    private function calculateChecksum(BufferInterface $entropy, int $CSlen): string
    {
        // entropy range (128, 256) yields (4, 8) bits of checksum
        $checksumChar = ord(Hash::sha256($entropy)->getBinary()[0]);
        $cs = '';
        for ($i = 0; $i < $CSlen; $i++) {
            $cs .= $checksumChar >> (7 - $i) & 1;
        }

        return $cs;
    }

    /**
     * @param BufferInterface $entropy
     * @return string[] - array of words from the word list
     */
    public function entropyToWords(BufferInterface $entropy): array
    {
        $ENT = $entropy->getSize() * 8;
        if (!in_array($entropy->getSize() * 8, $this->validEntropySizes)) {
            throw new \InvalidArgumentException("Invalid entropy length");
        }

        $CS = $ENT >> 5; // divide by 32, convinces static analysis result is an integer
        $bits = gmp_strval($entropy->getGmp(), 2) . $this->calculateChecksum($entropy, $CS);
        $bits = str_pad($bits, ($ENT + $CS), '0', STR_PAD_LEFT);

        $result = [];
        foreach (str_split($bits, 11) as $bit) {
            $result[] = $this->wordList->getWord(bindec($bit));
        }

        return $result;
    }

    /**
     * @param BufferInterface $entropy
     * @return string
     */
    public function entropyToMnemonic(BufferInterface $entropy): string
    {
        return implode(' ', $this->entropyToWords($entropy));
    }

    /**
     * @param string $mnemonic
     * @return BufferInterface
     */
    public function mnemonicToEntropy(string $mnemonic): BufferInterface
    {
        $words = explode(' ', $mnemonic);

        // Mnemonic sizes are multiples of 3 words
        if (count($words) % 3 !== 0) {
            throw new \InvalidArgumentException('Invalid mnemonic');
        }

        // Build up $bits from the list of words
        $bits = '';
        foreach ($words as $word) {
            $idx = $this->wordList->getIndex($word);
            // Mnemonic bit sizes are multiples of 33 bits
            $bits .= str_pad(decbin($idx), 11, '0', STR_PAD_LEFT);
        }

        // Every 32 bits of ENT adds a 1 CS bit.
        $CS = strlen($bits) / 33;
        $ENT = strlen($bits) - $CS;
        if (!in_array($ENT, $this->validEntropySizes)) {
            throw new \InvalidArgumentException('Invalid mnemonic - entropy size is invalid');
        }

        // Checksum bits
        $csBits = substr($bits, $ENT, $CS);

        // Split $ENT bits into 8 bit words to be packed
        $entArray = str_split(substr($bits, 0, $ENT), 8);
        $chars = [];
        for ($i = 0; $i < $ENT / 8; $i++) {
            $chars[] = bindec($entArray[$i]);
        }

        // Check checksum
        $entropy = new Buffer(pack("C*", ...$chars));
        if (hash_equals($csBits, $this->calculateChecksum($entropy, $CS))) {
            return $entropy;
        } else {
            throw new \InvalidArgumentException('Checksum does not match');
        }
    }
}
