/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Transaction;

use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\Factory\TxBuilder;
use BitWasp\Bitcoin\Transaction\Mutator\TxMutator;
use BitWasp\Bitcoin\Transaction\Transaction;
use BitWasp\Bitcoin\Transaction\TransactionFactory;

class TransactionFactoryTest extends AbstractTestCase
{
    public function testBuilder()
    {
        $builder = TransactionFactory::build();
        $this->assertInstanceOf(TxBuilder::class, $builder);
    }

    public function testMutateSigner()
    {
        $signer = TransactionFactory::mutate(new Transaction());
        $this->assertInstanceOf(TxMutator::class, $signer);
    }
}
