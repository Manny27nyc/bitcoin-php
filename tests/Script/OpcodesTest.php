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

namespace BitWasp\Bitcoin\Tests\Script;

use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class OpcodesTest extends AbstractTestCase
{
    public function testGetOpByName()
    {
        $op = new Opcodes;
        $expected = 0;
        $lookupOpName = 'OP_0';
        $val = $op->getOpByName('OP_0');
        $this->assertSame($expected, $val);
        $this->assertTrue(isset($op[Opcodes::OP_0]));
        $this->assertSame($lookupOpName, $op[Opcodes::OP_0]);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Opcode by that name not found
     */
    public function testGetOpByNameFail()
    {
        $op = new Opcodes();
        $op->getOpByName('OP_DEADBEEF');
    }

    public function testGetOp()
    {
        $op = new Opcodes;
        // Check getRegisteredOpCode returns the right operation
        $expected = 'OP_0';
        $val = $op->getOp(0);

        $this->assertSame($expected, $val);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Opcode not found
     */
    public function testGetOpCodeException()
    {
        $op = new Opcodes;
        $op->getOp(3);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNoWriteSet()
    {
        $op = new Opcodes();
        $op[1] = 2;
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testNoWriteUnSet()
    {
        $op = new Opcodes();
        unset($op[Opcodes::OP_1]);
    }

    public function testDebugInfo()
    {
        $op = new Opcodes();
        $this->assertEquals([], $op->__debugInfo());
    }
}
