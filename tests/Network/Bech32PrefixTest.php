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

namespace BitWasp\Bitcoin\Tests\Network;

use BitWasp\Bitcoin\Exceptions\MissingBech32Prefix;
use BitWasp\Bitcoin\Network\Network;
use BitWasp\Bitcoin\Network\Networks\Bitcoin;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class Bech32PrefixTest extends AbstractTestCase
{
    public function testHasKnownBech32Byte()
    {
        $method = new \ReflectionMethod(Bitcoin::class, 'hasBech32Prefix');
        $method->setAccessible(true);
        $hasPrefix = $method->invoke(new Bitcoin(), Network::BECH32_PREFIX_SEGWIT);
        $this->assertTrue($hasPrefix);
    }

    public function testHasUnknownBech32Byte()
    {
        $method = new \ReflectionMethod(Bitcoin::class, 'hasBech32Prefix');
        $method->setAccessible(true);
        $hasPrefix = $method->invoke(new Bitcoin(), "don't know this one");
        $this->assertFalse($hasPrefix);
    }

    public function testGetKnownBech32Byte()
    {
        $method = new \ReflectionMethod(Bitcoin::class, 'getBech32Prefix');
        $method->setAccessible(true);
        $prefix = $method->invoke(new Bitcoin(), Network::BECH32_PREFIX_SEGWIT);
        $this->assertSame('bc', $prefix);
    }

    public function testGetUnknownBech32Byte()
    {
        $method = new \ReflectionMethod(Bitcoin::class, 'getBech32Prefix');
        $method->setAccessible(true);

        $this->expectException(MissingBech32Prefix::class);

        $method->invoke(new Bitcoin(), "unknown!");
    }

    public function testGetBech32TypeByte()
    {
        $network = new Bitcoin();
        $method = new \ReflectionProperty(Bitcoin::class, 'bech32PrefixMap');
        $method->setAccessible(true);

        $map = $value = $method->getValue($network);
        $this->assertEquals($map[Network::BECH32_PREFIX_SEGWIT], $network->getSegwitBech32Prefix());
    }
}
