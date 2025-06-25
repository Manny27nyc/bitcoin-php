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

namespace BitWasp\Bitcoin\Tests\Chain;

use BitWasp\Bitcoin\Chain\BlockLocator;
use BitWasp\Bitcoin\Serializer\Chain\BlockLocatorSerializer;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class BlockLocatorTest extends AbstractTestCase
{
    public function testCreate()
    {
        $hash1 = new Buffer('A', 32);
        $hash2 = new Buffer('B', 32);
        $hashStop = new Buffer('', 32);
        $locator = new BlockLocator([$hash1, $hash2], $hashStop);

        $this->assertEquals([$hash1, $hash2], $locator->getHashes());
        $this->assertEquals($hashStop, $locator->getHashStop());
    }

    public function testsSerializer()
    {
        $hash1 = new Buffer(str_pad('', 32, 'A'), 32);
        $hash2 = new Buffer(str_pad('', 32, 'A'), 32);
        $hashStop = new Buffer(str_pad('', 32, '0'), 32);
        $locator = new BlockLocator([$hash1, $hash2], $hashStop);

        $serializer = new BlockLocatorSerializer();
        $buffer = $serializer->serialize($locator);
        $this->assertEquals($buffer->getBinary(), $locator->getBinary());

        $parsed = $serializer->parse($buffer);
        $this->assertEquals($locator, $parsed);
    }
}
