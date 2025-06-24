/*
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
