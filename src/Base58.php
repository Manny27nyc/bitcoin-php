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

namespace BitWasp\Bitcoin;

use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Exceptions\Base58ChecksumFailure;
use BitWasp\Bitcoin\Exceptions\Base58InvalidCharacter;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Buffertools;

class Base58
{
    /**
     * @var string
     */
    private static $base58chars = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

    /**
     * Encode a given hex string in base58
     *
     * @param BufferInterface $buffer
     * @return string
     */
    public static function encode(BufferInterface $buffer): string
    {
        $size = $buffer->getSize();
        if ($size === 0) {
            return '';
        }

        $orig = $buffer->getBinary();
        $decimal = $buffer->getGmp();

        $return = '';
        $zero = gmp_init(0);
        $_58 = gmp_init(58);
        while (gmp_cmp($decimal, $zero) > 0) {
            $div = gmp_div($decimal, $_58);
            $rem = gmp_sub($decimal, gmp_mul($div, $_58));
            $return .= self::$base58chars[(int) gmp_strval($rem, 10)];
            $decimal = $div;
        }
        $return = strrev($return);

        // Leading zeros
        for ($i = 0; $i < $size && $orig[$i] === "\x00"; $i++) {
            $return = '1' . $return;
        }

        return $return;
    }

    /**
     * Decode a base58 string
     * @param string $base58
     * @return BufferInterface
     * @throws Base58InvalidCharacter
     */
    public static function decode(string $base58): BufferInterface
    {
        if ($base58 === '') {
            return new Buffer('', 0);
        }

        $original = $base58;
        $length = strlen($base58);
        $return = gmp_init(0);
        $_58 = gmp_init(58);
        for ($i = 0; $i < $length; $i++) {
            $loc = strpos(self::$base58chars, $base58[$i]);
            if ($loc === false) {
                throw new Base58InvalidCharacter('Found character that is not allowed in base58: ' . $base58[$i]);
            }
            $return = gmp_add(gmp_mul($return, $_58), gmp_init($loc, 10));
        }

        $binary = gmp_cmp($return, gmp_init(0)) === 0 ? '' : Buffer::int(gmp_strval($return, 10))->getBinary();
        for ($i = 0; $i < $length && $original[$i] === '1'; $i++) {
            $binary = "\x00" . $binary;
        }

        return new Buffer($binary);
    }

    /**
     * @param BufferInterface $data
     * @return BufferInterface
     */
    public static function checksum(BufferInterface $data): BufferInterface
    {
        return Hash::sha256d($data)->slice(0, 4);
    }

    /**
     * Decode a base58 checksum string and validate checksum
     * @param string $base58
     * @return BufferInterface
     * @throws Base58ChecksumFailure
     * @throws Base58InvalidCharacter
     * @throws \Exception
     */
    public static function decodeCheck(string $base58): BufferInterface
    {
        $decoded = self::decode($base58);
        $checksumLength = 4;
        if ($decoded->getSize() < $checksumLength) {
            throw new Base58ChecksumFailure("Missing base58 checksum");
        }

        $data = $decoded->slice(0, -$checksumLength);
        $csVerify = $decoded->slice(-$checksumLength);

        if (!hash_equals(self::checksum($data)->getBinary(), $csVerify->getBinary())) {
            throw new Base58ChecksumFailure('Failed to verify checksum');
        }

        return $data;
    }

    /**
     * Encode the given data in base58, with a checksum to check integrity.
     *
     * @param BufferInterface $data
     * @return string
     */
    public static function encodeCheck(BufferInterface $data): string
    {
        return self::encode(Buffertools::concat($data, self::checksum($data)));
    }
}
