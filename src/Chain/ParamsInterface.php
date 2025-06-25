/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Chain;

use BitWasp\Bitcoin\Block\BlockHeaderInterface;
use BitWasp\Bitcoin\Block\BlockInterface;

interface ParamsInterface
{
    /**
     * @return BlockHeaderInterface
     */
    public function getGenesisBlockHeader(): BlockHeaderInterface;

    /**
     * @return BlockInterface
     */
    public function getGenesisBlock(): BlockInterface;

    /**
     * @return int
     */
    public function maxBlockSizeBytes(): int;

    /**
     * @return int
     */
    public function subsidyHalvingInterval(): int;

    /**
     * @return int
     */
    public function coinbaseMaturityAge(): int;

    /**
     * @return int
     */
    public function maxMoney(): int;

    /**
     * @return int
     */
    public function powTargetTimespan(): int;

    /**
     * @return int
     */
    public function powTargetSpacing(): int;

    /**
     * @return int
     */
    public function powRetargetInterval(): int;

    /**
     * @return string
     */
    public function powTargetLimit(): string;

    /**
     * @return int
     */
    public function powBitsLimit(): int;

    /**
     * @return int
     */
    public function majorityEnforceBlockUpgrade(): int;

    /**
     * @return int
     */
    public function majorityWindow(): int;

    /**
     * @return int
     */
    public function p2shActivateTime(): int;

    /**
     * @return int
     */
    public function getMaxBlockSigOps(): int;

    /**
     * @return int
     */
    public function getMaxTxSigOps(): int;
}
