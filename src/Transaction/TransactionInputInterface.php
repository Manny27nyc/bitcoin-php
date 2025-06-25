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

namespace BitWasp\Bitcoin\Transaction;

use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\SerializableInterface;

interface TransactionInputInterface extends SerializableInterface
{
    /**
     * The default sequence.
     */
    const SEQUENCE_FINAL = 0xffffffff;

    /* If this flag set, CTxIn::nSequence is NOT interpreted as a
     * relative lock-time. */
    const SEQUENCE_LOCKTIME_DISABLE_FLAG = 1 << 31; // 1 << 31

    /* If CTxIn::nSequence encodes a relative lock-time and this flag
     * is set, the relative lock-time has units of 512 seconds,
     * otherwise it specifies blocks with a granularity of 1. */
    const SEQUENCE_LOCKTIME_TYPE_FLAG = 1 << 22; // 1 << 22;

    /* If CTxIn::nSequence encodes a relative lock-time, this mask is
     * applied to extract that lock-time from the sequence field. */
    const SEQUENCE_LOCKTIME_MASK = 0x0000ffff;

    /**
     * Get the outpoint
     *
     * @return OutPointInterface
     */
    public function getOutPoint(): OutPointInterface;

    /**
     * Get the scriptSig for this input
     *
     * @return ScriptInterface
     */
    public function getScript(): ScriptInterface;

    /**
     * Get the sequence number for this input
     *
     * @return int
     */
    public function getSequence(): int;

    /**
     * Equality check with $this and $other
     *
     * @param TransactionInputInterface $other
     * @return bool
     */
    public function equals(TransactionInputInterface $other): bool;

    /**
     * Check whether the transaction is the Coinbase, ie, it has
     * one input which spends the `null` outpoint
     *
     * @return bool
     */
    public function isCoinBase(): bool;

    /**
     * @return bool
     */
    public function isFinal(): bool;

    /**
     * Checks whether the SEQUENCE_LOCKTIME_DISABLE_FLAG is set
     * Always returns true if txin is coinbase.
     *
     * @return bool
     */
    public function isSequenceLockDisabled(): bool;

    /**
     * Indicates whether the input is locked with a time based lock (as opposed to block)
     *
     * @return bool
     */
    public function isLockedToTime(): bool;

    /**
     * Returns whether the input is locked with a block based lock (as opposed to time)
     *
     * @return bool
     */
    public function isLockedToBlock(): bool;

    /**
     * Returns the relative block time for the input.
     * Range limited to 0 - 33553920 (approx 1 yr)
     * @return int
     */
    public function getRelativeBlockLock(): int;

    /**
     * Returns the relative locktime for the input in seconds.
     * Range limited to 0 - 65535
     *
     * @return int
     */
    public function getRelativeTimeLock(): int;
}
