/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Transaction\SignatureHash;

use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Buffertools\BufferInterface;

interface SigHashInterface
{
    /**
     * Default procedure: Sign ALL of the outputs.
     */
    const ALL = 1;

    /**
     * Sign NONE of the outputs, I don't care where the bitcoins go.
     */
    const NONE = 2;

    /**
     * Sign ONE of the outputs, I don't care where the others go.
     */
    const SINGLE = 3;

    /**
     * Let other people add inputs to this transaction paying X. I don't
     * care who else pays. (can be used with other sighash flags)
     */
    const ANYONECANPAY = 128;

    /**
     * Calculate the hash of the current transaction, when you are looking to
     * spend $txOut, and are signing $inputToSign. The SigHashType defaults to
     * SIGHASH_ALL, though SIGHASH_SINGLE, SIGHASH_NONE, SIGHASH_ANYONECANPAY
     * can be used.
     *
     * @param ScriptInterface $txOutScript
     * @param int $inputToSign
     * @param int $sighashType
     * @return \BitWasp\Buffertools\BufferInterface
     */
    public function calculate(
        ScriptInterface $txOutScript,
        int $inputToSign,
        int $sighashType = SigHash::ALL
    ): BufferInterface;
}
