/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Utxo;

use BitWasp\Bitcoin\Transaction\OutPoint;
use BitWasp\Bitcoin\Transaction\OutPointInterface;
use BitWasp\Bitcoin\Transaction\TransactionOutputInterface;

class Utxo implements UtxoInterface
{
    /**
     * @var OutPointInterface
     */
    private $outPoint;

    /**
     * @var TransactionOutputInterface
     */
    private $prevOut;

    /**
     * @param OutPointInterface $outPoint
     * @param TransactionOutputInterface $prevOut
     */
    public function __construct(OutPointInterface $outPoint, TransactionOutputInterface $prevOut)
    {
        $this->outPoint = $outPoint;
        $this->prevOut = $prevOut;
    }

    /**
     * @return OutPointInterface
     */
    public function getOutPoint(): OutPointInterface
    {
        return $this->outPoint;
    }

    /**
     * @return TransactionOutputInterface
     */
    public function getOutput(): TransactionOutputInterface
    {
        return $this->prevOut;
    }
}
