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

namespace BitWasp\Bitcoin\Tests\Key\Deterministic;

use BitWasp\Bitcoin\Key\Deterministic\HierarchicalKeySequence;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class HierarchicalKeySequenceTest extends AbstractTestCase
{
    public function getSequenceVectors()
    {
        return [
            ['0', 0],
            ['0h', 2147483648],
            ["0'", 2147483648],
            ['1h', 2147483649],
            ['2147483647h', 4294967295],
        ];
    }

    /**
     * @dataProvider getSequenceVectors
     * @param $node
     * @param $eSeq
     */
    public function testGetSequence($node, $eSeq)
    {
        $sequence = new HierarchicalKeySequence();
        $this->assertEquals([$eSeq], $sequence->decodeRelative($node));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDecodePathFailure()
    {
        $sequence = new HierarchicalKeySequence();
        $sequence->decodeRelative('');
    }

    public function testDecodePath()
    {
        $sequence = new HierarchicalKeySequence();

        $expected = ['2147483648','2147483649','444','2147526030'];
        $this->assertEquals($expected, $sequence->decodeRelative("0'/1'/444/42382'"));
    }

    /**
     * @dataProvider getSequenceVectors
     * @param $node
     * @param $integer
     */
    public function testDecodePathVectors($node, $integer)
    {
        $sequence = new HierarchicalKeySequence();

        // There should only be one, just implode to get the value
        $this->assertEquals($integer, implode("", $sequence->decodeRelative($node)));
    }
}
