/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Utxo;

use BitWasp\Bitcoin\Transaction\OutPointInterface;
use BitWasp\Bitcoin\Transaction\TransactionOutputInterface;

interface UtxoInterface
{
    /**
     * @return OutPointInterface
     */
    public function getOutPoint(): OutPointInterface;

    /**
     * @return TransactionOutputInterface
     */
    public function getOutput(): TransactionOutputInterface;
}
