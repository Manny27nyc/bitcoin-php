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

namespace BitWasp\Bitcoin\Tests\Transaction;

use BitWasp\Bitcoin\Script\Script;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Transaction\OutPoint;
use BitWasp\Bitcoin\Transaction\TransactionInput;
use BitWasp\Buffertools\Buffer;
use PHPUnit\Framework\TestCase;

class TransactionInputTest extends TestCase
{
    public function testGetSequence()
    {
        // test default
        $in = new TransactionInput(new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 0), new Script());
        $this->assertSame(0xffffffff, $in->getSequence());
        $this->assertTrue($in->isFinal());
        $this->assertTrue($in->isSequenceLockDisabled());

        // test when set
        $in = new TransactionInput(new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 0), new Script(), 23);
        $this->assertSame(23, $in->getSequence());
        $this->assertFalse($in->isFinal());
        $this->assertFalse($in->isSequenceLockDisabled());
    }

    public function testSequenceLock()
    {
        // Disabled because disable bit is set
        $in = new TransactionInput(new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 0), new Script(), 0xffffffff);
        $this->assertTrue($in->isSequenceLockDisabled());

        // Disable because of coinbase
        $in = new TransactionInput(new OutPoint(new Buffer('', 32), 0xffffffff), new Script(), 0x7fffffff);
        $this->assertTrue($in->isSequenceLockDisabled());

        // Disable bit not set, but all bits set
        $in = new TransactionInput(new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 0), new Script(), 0x7fffffff);

        // Not disabled
        $this->assertFalse($in->isSequenceLockDisabled());

        // Timelocked (because 22 is set)
        $this->assertFalse($in->isLockedToBlock());
        $this->assertTrue($in->isLockedToTime());

        // Returns max relative locktime in seconds
        $this->assertEquals(0xffff*512, $in->getRelativeTimeLock());

        // Disable bit not set, nor is timelock bit

        $in = new TransactionInput(new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 0), new Script(), 0x7fbfffff);
        $this->assertFalse($in->isSequenceLockDisabled());
        $this->assertTrue($in->isLockedToBlock());
        $this->assertFalse($in->isLockedToTime());

        $this->assertEquals(0xffff, $in->getRelativeBlockLock());
    }

    public function testConstructWithScript()
    {
        $outpoint = new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 0);

        $scriptBuf = new Buffer('03010203');
        $script = ScriptFactory::create()->push($scriptBuf)->getScript();
        $sequence = 0;

        $t = new TransactionInput($outpoint, $script, $sequence);
        $this->assertSame($outpoint, $t->getOutPoint());
        $this->assertSame($script, $t->getScript());
        $this->assertSame($sequence, $t->getSequence());
    }

    public function testGetScript()
    {
        $script = new Script(Buffer::hex('41'));
        $in = new TransactionInput(new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 0), $script);

        $this->assertInstanceOf(Script::class, $in->getScript());
        $this->assertEquals($script, $in->getScript());
    }

    public function testIsCoinbase()
    {
        $in = new TransactionInput(new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 0), new Script());
        $this->assertFalse($in->isCoinbase());

        $in = new TransactionInput(new OutPoint(Buffer::hex('7f8e94bdf85de933d5417145e4b76926777fa2a2d8fe15b684cfd835f43b8b33', 32), 4294967295), new Script());
        $this->assertFalse($in->isCoinbase());

        $in = new TransactionInput(new OutPoint(Buffer::hex('0000000000000000000000000000000000000000000000000000000000000000', 32), 0), new Script());
        $this->assertFalse($in->isCoinbase());

        $in = new TransactionInput(new OutPoint(Buffer::hex('0000000000000000000000000000000000000000000000000000000000000000', 32), 4294967295), new Script());
        $this->assertTrue($in->isCoinbase());
    }

    public function testEquals()
    {
        $in1 = new TransactionInput(new OutPoint(Buffer::hex('0000000000000000000000000000000000000000000000000000000000000000', 32), 4294967295), new Script(), 1);
        $in1eq = new TransactionInput(new OutPoint(Buffer::hex('0000000000000000000000000000000000000000000000000000000000000000', 32), 4294967295), new Script(), 1);

        $inBadOut = new TransactionInput(new OutPoint(Buffer::hex('0000000000000000000000000000000000000000000000000000000000000000', 32), 1), new Script(), 1);
        $inBadScript = new TransactionInput(new OutPoint(Buffer::hex('0000000000000000000000000000000000000000000000000000000000000000', 32), 4294967295), new Script(new Buffer('a')), 1);
        $inBadSeq = new TransactionInput(new OutPoint(Buffer::hex('0000000000000000000000000000000000000000000000000000000000000000', 32), 4294967295), new Script(), 123123);

        $this->assertTrue($in1->equals($in1eq));
        $this->assertFalse($in1->equals($inBadOut));
        $this->assertFalse($in1->equals($inBadScript));
        $this->assertFalse($in1->equals($inBadSeq));
    }
}
