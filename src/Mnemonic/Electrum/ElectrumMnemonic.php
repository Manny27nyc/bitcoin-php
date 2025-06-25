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

namespace BitWasp\Bitcoin\Mnemonic\Electrum;

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Mnemonic\MnemonicInterface;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class ElectrumMnemonic implements MnemonicInterface
{
    /**
     * @var EcAdapterInterface
     */
    private $ecAdapter;

    /**
     * @var ElectrumWordListInterface
     */
    private $wordList;

    /**
     * @param EcAdapterInterface $ecAdapter
     * @param ElectrumWordListInterface $wordList
     */
    public function __construct(EcAdapterInterface $ecAdapter, ElectrumWordListInterface $wordList)
    {
        $this->ecAdapter = $ecAdapter;
        $this->wordList = $wordList;
    }

    /**
     * @param BufferInterface $entropy
     * @return string[]
     * @throws \Exception
     */
    public function entropyToWords(BufferInterface $entropy): array
    {
        $math = $this->ecAdapter->getMath();
        $n = gmp_init(count($this->wordList), 10);
        $wordArray = [];

        $chunks = $entropy->getSize() / 4;
        for ($i = 0; $i < $chunks; $i++) {
            $x = $entropy->slice(4*$i, 4)->getGmp();
            $index1 = $math->mod($x, $n);
            $index2 = $math->mod($math->add($math->div($x, $n), $index1), $n);
            $index3 = $math->mod($math->add($math->div($math->div($x, $n), $n), $index2), $n);

            $wordArray[] = $this->wordList->getWord((int) gmp_strval($index1, 10));
            $wordArray[] = $this->wordList->getWord((int) gmp_strval($index2, 10));
            $wordArray[] = $this->wordList->getWord((int) gmp_strval($index3, 10));
        }

        return $wordArray;
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
        $math = $this->ecAdapter->getMath();
        $wordList = $this->wordList;
        $words = explode(' ', $mnemonic);
        $n = gmp_init(count($wordList), 10);
        $thirdWordCount = count($words) / 3;
        $out = '';

        for ($i = 0; $i < $thirdWordCount; $i++) {
            list ($index1, $index2, $index3) = array_map(function ($v) use ($wordList) {
                return gmp_init($wordList->getIndex($v), 10);
            }, array_slice($words, 3 * $i, 3));

            $x = $math->add(
                $index1,
                $math->add(
                    $math->mul(
                        $n,
                        $math->mod($math->sub($index2, $index1), $n)
                    ),
                    $math->mul(
                        $n,
                        $math->mul(
                            $n,
                            $math->mod($math->sub($index3, $index2), $n)
                        )
                    )
                )
            );
            
            $out .= str_pad(gmp_strval($x, 16), 8, '0', STR_PAD_LEFT);
        }

        return Buffer::hex($out);
    }
}
