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

namespace BitWasp\Bitcoin\Tests;

use BitWasp\Bitcoin\Amount;

class AmountTest extends AbstractTestCase
{
    public function getVectors()
    {
        return [
            ['0.01000000', 1000000],
            ['1', Amount::COIN],
            ['1.12345678', 112345678],
            ['21000000', 2100000000000000],
            ['0', 0],
            ['0.0', 0]
        ];
    }

    /**
     * @param string $btc
     * @param int $satoshis
     * @dataProvider getVectors
     */
    public function testAmount(string $btc, int $satoshis)
    {
        $amount = new Amount();
        $this->assertEquals($btc, $amount->toBtc($satoshis));
        $this->assertEquals($satoshis, $amount->toSatoshis($btc));
    }

    public function testIgnoresLowValues()
    {
        $amount = new Amount();
        $value = '1.123456789';
        $expected = 112345678;
        $this->assertEquals($expected, ($amount->toSatoshis($value)));
    }
}
