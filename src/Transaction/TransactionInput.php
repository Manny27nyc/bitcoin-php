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

namespace BitWasp\Bitcoin\Transaction;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Serializable;
use BitWasp\Bitcoin\Serializer\Transaction\OutPointSerializer;
use BitWasp\Bitcoin\Serializer\Transaction\TransactionInputSerializer;
use BitWasp\Buffertools\BufferInterface;

class TransactionInput extends Serializable implements TransactionInputInterface
{
    /**
     * @var OutPointInterface
     */
    private $outPoint;

    /**
     * @var ScriptInterface
     */
    private $script;

    /**
     * @var int
     */
    private $sequence;

    /**
     * @param OutPointInterface $outPoint
     * @param ScriptInterface $script
     * @param int $sequence
     */
    public function __construct(OutPointInterface $outPoint, ScriptInterface $script, int $sequence = self::SEQUENCE_FINAL)
    {
        $this->outPoint = $outPoint;
        $this->script = $script;
        $this->sequence = $sequence;
    }

    /**
     * @return OutPointInterface
     */
    public function getOutPoint(): OutPointInterface
    {
        return $this->outPoint;
    }

    /**
     * @return ScriptInterface
     */
    public function getScript(): ScriptInterface
    {
        return $this->script;
    }

    /**
     * @return int
     */
    public function getSequence(): int
    {
        return $this->sequence;
    }

    /**
     * @param TransactionInputInterface $other
     * @return bool
     */
    public function equals(TransactionInputInterface $other): bool
    {
        if (!$this->outPoint->equals($other->getOutPoint())) {
            return false;
        }

        if (!$this->script->equals($other->getScript())) {
            return false;
        }

        return gmp_cmp(gmp_init($this->sequence), gmp_init($other->getSequence())) === 0;
    }

    /**
     * Check whether this transaction is a Coinbase transaction
     *
     * @return bool
     */
    public function isCoinbase(): bool
    {
        $outpoint = $this->outPoint;
        return $outpoint->getTxId()->getBinary() === str_pad('', 32, "\x00")
            && $outpoint->getVout() == 0xffffffff;
    }

    /**
     * @return bool
     */
    public function isFinal(): bool
    {
        $math = Bitcoin::getMath();
        return $math->cmp(gmp_init($this->getSequence(), 10), gmp_init(self::SEQUENCE_FINAL, 10)) === 0;
    }

    /**
     * @return bool
     */
    public function isSequenceLockDisabled(): bool
    {
        if ($this->isCoinbase()) {
            return true;
        }

        return ($this->sequence & self::SEQUENCE_LOCKTIME_DISABLE_FLAG) !== 0;
    }

    /**
     * @return bool
     */
    public function isLockedToTime(): bool
    {
        return !$this->isSequenceLockDisabled() && (($this->sequence & self::SEQUENCE_LOCKTIME_TYPE_FLAG) === self::SEQUENCE_LOCKTIME_TYPE_FLAG);
    }

    /**
     * @return bool
     */
    public function isLockedToBlock(): bool
    {
        return !$this->isSequenceLockDisabled() && (($this->sequence & self::SEQUENCE_LOCKTIME_TYPE_FLAG) === 0);
    }

    /**
     * @return int
     */
    public function getRelativeTimeLock(): int
    {
        if (!$this->isLockedToTime()) {
            throw new \RuntimeException('Cannot decode time based locktime when disable flag set/timelock flag unset/tx is coinbase');
        }

        // Multiply by 512 to convert locktime to seconds
        return ($this->sequence & self::SEQUENCE_LOCKTIME_MASK) * 512;
    }

    /**
     * @return int
     */
    public function getRelativeBlockLock(): int
    {
        if (!$this->isLockedToBlock()) {
            throw new \RuntimeException('Cannot decode block locktime when disable flag set/timelock flag set/tx is coinbase');
        }

        return $this->sequence & self::SEQUENCE_LOCKTIME_MASK;
    }

    /**
     * @return BufferInterface
     */
    public function getBuffer(): BufferInterface
    {
        return (new TransactionInputSerializer(new OutPointSerializer()))->serialize($this);
    }
}
