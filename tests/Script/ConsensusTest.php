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

namespace BitWasp\Bitcoin\Tests\Script;

use BitWasp\Bitcoin\Script\Consensus\BitcoinConsensus;
use BitWasp\Bitcoin\Script\Consensus\ConsensusInterface;
use BitWasp\Bitcoin\Script\Consensus\NativeConsensus;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Script\ScriptWitnessInterface;

class ConsensusTest extends ScriptCheckTestBase
{
    public function testGetNativeConsensus()
    {
        $this->assertInstanceOf(NativeConsensus::class, ScriptFactory::getNativeConsensus());
    }

    public function getExpectedAdapter()
    {
        return extension_loaded('bitcoinconsensus')
            ? BitcoinConsensus::class
            : NativeConsensus::class;
    }

    public function testGetBitcoinConsensus()
    {
        if ($this->getExpectedAdapter() === BitcoinConsensus::class) {
            $this->assertInstanceOf(BitcoinConsensus::class, ScriptFactory::getBitcoinConsensus());
        }
    }

    public function testDefaultAdapter()
    {
        $this->assertInstanceOf($this->getExpectedAdapter(), ScriptFactory::consensus());
    }

    /**
     * @return array
     */
    public function prepareConsensusTests()
    {
        $adapters = $this->getConsensusAdapters($this->getEcAdapters());
        $vectors = [];
        foreach ($this->prepareTestData() as $fixture) {
            list ($flags, $returns, $scriptWitness, $scriptSig, $scriptPubKey, $amount, $strTest) = $fixture;
            foreach ($adapters as $consensusFixture) {
                list ($consensus) = $consensusFixture;

                if ($consensus instanceof BitcoinConsensus) {
                    // Some conditions are untestable because recent libbitcoinconsensus
                    // versions reject usage of some flags. We skip verification of some
                    // of these, should be a @todo determine how many of these tests are
                    // skipped
                    if ($flags !== ($flags & BITCOINCONSENSUS_SCRIPT_FLAGS_VERIFY_ALL)) {
                        continue;
                    }
                }

                $vectors[] = [$consensus, $flags, $returns, $scriptWitness, $scriptSig, $scriptPubKey, $amount, $strTest];
            }
        }

        return $vectors;
    }

    /**
     * @param ConsensusInterface $consensus
     * @param int $flags
     * @param bool $expectedResult
     * @param ScriptWitnessInterface $scriptWitness
     * @param ScriptInterface $scriptSig
     * @param ScriptInterface $scriptPubKey
     * @param int $amount
     * @param string $strTest
     * @dataProvider prepareConsensusTests
     */
    public function testScript(
        ConsensusInterface $consensus,
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
        $check = $consensus->verify($tx, $scriptPubKey, $flags, 0, $amount);

        $this->assertEquals($expectedResult, $check, $strTest);
    }
}
