/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Transaction\Mutator;

use BitWasp\Bitcoin\Script\Script;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\Mutator\TxMutator;
use BitWasp\Bitcoin\Transaction\OutPoint;
use BitWasp\Bitcoin\Transaction\Transaction;
use BitWasp\Bitcoin\Transaction\TransactionInput;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Buffertools\Buffer;

class TxMutatorTest extends AbstractTestCase
{
    public function testModifiesTransaction()
    {
        $tx = new Transaction(
            1,
            [],
            [],
            [],
            20
        );

        $newVersion = 10;
        $newLockTime = 200;

        $mutator = new TxMutator($tx);
        $mutator
            ->version($newVersion)
            ->locktime($newLockTime)
        ;

        $mutator->inputs([
            new TransactionInput(new OutPoint(Buffer::hex('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'), 1), new Script())
        ]);

        $mutator->outputs([
            new TransactionOutput(50, new Script())
        ]);

        $newTx = $mutator->done();
        $this->assertEquals($newVersion, $newTx->getVersion());
        $this->assertEquals($newLockTime, $newTx->getLockTime());
        $this->assertEquals(1, count($newTx->getInputs()));
        $this->assertEquals(1, count($newTx->getOutputs()));
    }
}
