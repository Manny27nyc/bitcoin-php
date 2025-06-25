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

namespace BitWasp\Bitcoin\Tests\Script\Branch;

use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Bitcoin\Script\Parser\Operation;
use BitWasp\Bitcoin\Script\Path\PathTracer;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class PathTracerTest extends AbstractTestCase
{
    public function testTraceNoOperations()
    {
        $tracer = new PathTracer();
        $result = $tracer->done();

        $this->assertInternalType('array', $result);
        $this->assertEquals(0, count($result));

        $resultAgain = $tracer->done();
        $this->assertSame($result, $resultAgain);
    }

    public function testTraceJustOneOperation()
    {
        $op0 = new Operation(Opcodes::OP_0, new Buffer());

        $tracer = new PathTracer();
        $tracer->operation($op0);

        $result = $tracer->done();

        $this->assertInternalType('array', $result);
        $this->assertEquals(1, count($result));

        $resultAgain = $tracer->done();
        $this->assertSame($result, $resultAgain);

        $op1 = new Operation(Opcodes::OP_1, new Buffer("\x01"));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Cannot add operation to finished PathTracer");

        $tracer->operation($op1);
    }
}
