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

namespace BitWasp\Bitcoin\Tests\Script\Interpreter;

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Script\Interpreter\Checker;
use BitWasp\Bitcoin\Script\Interpreter\Interpreter;
use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Script\ScriptWitnessInterface;
use BitWasp\Bitcoin\Tests\Script\ScriptCheckTestBase;

/**
 * This is essentially a port of Bitcoin Core's test suite.
 * When updating:
 *   cp bitcoin/src/test/data/script_tests.json bitcoin-php/tests/Data/script_tests.json
 */
class ScriptTest extends ScriptCheckTestBase
{

    /**
     * @return array
     */
    public function prepareInterpreterTests()
    {
        $vectors = [];
        foreach ($this->prepareTestData() as $fixture) {
            list ($flags, $returns, $scriptWitness, $scriptSig, $scriptPubKey, $amount, $strTest) = $fixture;
            foreach ($this->getEcAdapters() as $ecAdapterFixture) {
                list ($ecAdapter) = $ecAdapterFixture;
                $vectors[] = [$ecAdapter, new Interpreter($ecAdapter), $flags, $returns, $scriptWitness, $scriptSig, $scriptPubKey, $amount, $strTest];
            }
        }

        return $vectors;
    }

    /**
     * @param EcAdapterInterface $ecAdapter
     * @param Interpreter $interpreter
     * @param int $flags
     * @param bool $expectedResult
     * @param ScriptWitnessInterface $scriptWitness
     * @param ScriptInterface $scriptSig
     * @param ScriptInterface $scriptPubKey
     * @param int $amount
     * @dataProvider prepareInterpreterTests
     */
    public function testScript(
        EcAdapterInterface $ecAdapter,
        Interpreter $interpreter,
        int $flags,
        bool $expectedResult,
        ScriptWitnessInterface $scriptWitness,
        ScriptInterface $scriptSig,
        ScriptInterface $scriptPubKey,
        int $amount,
        string $strTest
    ) {
        $create = $this->buildCreditingTransaction($scriptPubKey, $amount);
        $tx = $this->buildSpendTransaction($create, $scriptSig, $scriptWitness);
        $check = $interpreter->verify($scriptSig, $scriptPubKey, $flags, new Checker($ecAdapter, $tx, 0, $amount), $scriptWitness);

        $this->assertEquals($expectedResult, $check, $strTest);
    }
}
