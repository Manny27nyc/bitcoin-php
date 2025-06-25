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

namespace BitWasp\Bitcoin\Tests\Key\Deterministic\HdPrefix;

use BitWasp\Bitcoin\Exceptions\InvalidNetworkParameter;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\ScriptPrefix;
use BitWasp\Bitcoin\Key\KeyToScript\Factory\P2wpkhScriptDataFactory;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class ScriptPrefixTest extends AbstractTestCase
{
    public function testScriptPrefix()
    {
        $factory = new P2wpkhScriptDataFactory();
        $pubPrefix = "04b24746";
        $privPrefix = "04b2430c";
        $prefix = new ScriptPrefix($factory, $privPrefix, $pubPrefix);
        $this->assertEquals($pubPrefix, $prefix->getPublicPrefix());
        $this->assertEquals($privPrefix, $prefix->getPrivatePrefix());
        $this->assertEquals($factory, $prefix->getScriptDataFactory());
    }

    public function testBadLengthPrivatePrefix()
    {
        $factory = new P2wpkhScriptDataFactory();
        $pubPrefix = "04b24746";
        $privPrefix = "dadd0c";
        $this->expectException(InvalidNetworkParameter::class);
        $this->expectExceptionMessage("Invalid HD private prefix: wrong length");

        new ScriptPrefix($factory, $privPrefix, $pubPrefix);
    }

    public function testBadHexPrivatePrefix()
    {
        $factory = new P2wpkhScriptDataFactory();
        $pubPrefix = "04b24746";
        $privPrefix = "dadgad0c";
        $this->expectException(InvalidNetworkParameter::class);
        $this->expectExceptionMessage("Invalid HD private prefix: expecting hex");

        new ScriptPrefix($factory, $privPrefix, $pubPrefix);
    }

    public function testBadLengthPublicPrefix()
    {
        $factory = new P2wpkhScriptDataFactory();
        $privPrefix = "04b24746";
        $pubPrefix = "dadd0c";
        $this->expectException(InvalidNetworkParameter::class);
        $this->expectExceptionMessage("Invalid HD public prefix: wrong length");

        new ScriptPrefix($factory, $privPrefix, $pubPrefix);
    }

    public function testBadHexPublicPrefix()
    {
        $factory = new P2wpkhScriptDataFactory();
        $privPrefix = "04b24746";
        $pubPrefix = "dadgad0c";
        $this->expectException(InvalidNetworkParameter::class);
        $this->expectExceptionMessage("Invalid HD public prefix: expecting hex");

        new ScriptPrefix($factory, $privPrefix, $pubPrefix);
    }
}
