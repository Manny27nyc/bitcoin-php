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

namespace BitWasp\Bitcoin\Mnemonic\Bip39;

use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class Bip39SeedGenerator
{
    /**
     * @param string $string
     * @return BufferInterface
     * @throws \Exception
     */
    private function normalize(string $string): BufferInterface
    {
        if (!class_exists('Normalizer')) {
            if (mb_detect_encoding($string) === 'UTF-8') {
                throw new \Exception('UTF-8 passphrase is not supported without the PECL intl extension installed.');
            } else {
                return new Buffer($string);
            }
        }

        return new Buffer(\Normalizer::normalize($string, \Normalizer::FORM_KD));
    }

    /**
     * @param string $mnemonic
     * @param string $passphrase
     * @return \BitWasp\Buffertools\BufferInterface
     * @throws \Exception
     */
    public function getSeed(string $mnemonic, string $passphrase = ''): BufferInterface
    {
        return Hash::pbkdf2(
            'sha512',
            $this->normalize($mnemonic),
            $this->normalize("mnemonic{$passphrase}"),
            2048,
            64
        );
    }
}
