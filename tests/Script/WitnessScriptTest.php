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

namespace BitWasp\Bitcoin\Tests\Script;

use BitWasp\Bitcoin\Exceptions\WitnessScriptException;
use BitWasp\Bitcoin\Script\P2shScript;
use BitWasp\Bitcoin\Script\Script;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Script\WitnessScript;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class WitnessScriptTest extends AbstractTestCase
{
    /**
     * @return array
     */
    public function getCannotNestVectors()
    {
        return [
            [new WitnessScript(new Script(new Buffer())), "Cannot nest V0 P2WSH scripts."],
            [new P2shScript(new Script(new Buffer())), "Cannot embed a P2SH script in a V0 P2WSH script."],
        ];
    }

    /**
     * @param ScriptInterface $testScript
     * @param string $exceptionMsg
     * @dataProvider getCannotNestVectors
     */
    public function testCannotNestWitnessScripts(ScriptInterface $testScript, string $exceptionMsg)
    {
        $this->expectException(WitnessScriptException::class);
        $this->expectExceptionMessage($exceptionMsg);

        new WitnessScript($testScript);
    }

    public function testNormalScriptHasSameBuffer()
    {
        $script = new Script(new Buffer());
        $witnessScriptHash = $script->getWitnessScriptHash();

        $witnessScript = new WitnessScript($script);
        $this->assertTrue($witnessScript->equals($script));

        $expectedOutputScript = ScriptFactory::scriptPubKey()->p2wsh($witnessScriptHash);
        $this->assertTrue($expectedOutputScript->equals($witnessScript->getOutputScript()));
    }
}
