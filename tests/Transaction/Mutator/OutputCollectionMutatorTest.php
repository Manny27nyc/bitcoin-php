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

namespace BitWasp\Bitcoin\Tests\Transaction\Mutator;

use BitWasp\Bitcoin\Script\Script;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\Mutator\OutputCollectionMutator;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Buffertools\Buffer;

class OutputCollectionMutatorTest extends AbstractTestCase
{
    public function testMutatesOutputCollection()
    {
        $value1 = 12;
        $script1 = new Script(new Buffer('0'));
        $value2 = 20;
        $script2 = new Script(new Buffer('1'));
        $collection = [
            new TransactionOutput(5, new Script()),
            new TransactionOutput(10, new Script()),
        ];

        $mutator = new OutputCollectionMutator($collection);
        $mutator[0]->script($script1)
                ->value($value1);

        $mutator[1]->script($script2)->value($value2);

        $new = $mutator->done();
        $this->assertEquals($value1, $new[0]->getValue());
        $this->assertEquals($script1, $new[0]->getScript());
        $this->assertEquals($value2, $new[1]->getValue());
        $this->assertEquals($script2, $new[1]->getScript());
    }

    public function testAdds()
    {
        $collection = [
            new TransactionOutput(5, new Script()),
            new TransactionOutput(10, new Script()),
        ];

        $mutator = new OutputCollectionMutator($collection);
        $mutator->add(new TransactionOutput(15, new Script()));
        $outputs = $mutator->done();

        $this->assertEquals(3, count($outputs));
    }

    public function testSlice()
    {
        $collection = [
            new TransactionOutput(5, new Script()),
            new TransactionOutput(10, new Script()),
        ];

        $mutator = new OutputCollectionMutator($collection);
        $mutator->slice(0, 1);
        $outputs = $mutator->done();

        $this->assertEquals(1, count($outputs));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidSlice()
    {
        $collection = [
        ];

        $mutator = new OutputCollectionMutator($collection);
        $mutator->slice(0, 1);
    }

    public function testNull()
    {
        $collection = [
            new TransactionOutput(5, new Script()),
            new TransactionOutput(10, new Script()),
        ];

        $mutator = new OutputCollectionMutator($collection);
        $mutator->null();
        $outputs = $mutator->done();

        $this->assertEquals(0, count($outputs));
    }

    public function testSet()
    {
        $collection = [
            new TransactionOutput(5, new Script()),
            new TransactionOutput(10, new Script()),
        ];

        $mutator = new OutputCollectionMutator($collection);
        $mutator->set(0, new TransactionOutput(1, new Script()));
        $newCollection = $mutator->done();
        $this->assertEquals(1, $newCollection[0]->getValue());
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testInvalidIndex()
    {
        $mutator = new OutputCollectionMutator([]);
        $mutator->offsetGet(10);
    }
}
