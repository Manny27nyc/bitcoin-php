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

namespace BitWasp\Bitcoin\Transaction\SignatureHash;

use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Serializer\Transaction\OutPointSerializer;
use BitWasp\Bitcoin\Serializer\Transaction\OutPointSerializerInterface;
use BitWasp\Bitcoin\Serializer\Transaction\TransactionOutputSerializer;
use BitWasp\Bitcoin\Transaction\TransactionInterface;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Buffertools;

class V1Hasher extends SigHash
{
    /**
     * @var TransactionInterface
     */
    protected $transaction;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var TransactionOutputSerializer
     */
    protected $outputSerializer;

    /**
     * @var OutPointSerializerInterface
     */
    protected $outpointSerializer;

    /**
     * V1Hasher constructor.
     * @param TransactionInterface $transaction
     * @param int $amount
     * @param OutPointSerializerInterface $outpointSerializer
     * @param TransactionOutputSerializer|null $outputSerializer
     */
    public function __construct(
        TransactionInterface $transaction,
        int $amount,
        OutPointSerializerInterface $outpointSerializer = null,
        TransactionOutputSerializer $outputSerializer = null
    ) {
        $this->amount = $amount;
        $this->outputSerializer = $outputSerializer ?: new TransactionOutputSerializer();
        $this->outpointSerializer = $outpointSerializer ?: new OutPointSerializer();
        parent::__construct($transaction);
    }

    /**
     * @param int $sighashType
     * @return BufferInterface
     */
    public function hashPrevOuts(int $sighashType): BufferInterface
    {
        if (!($sighashType & SigHash::ANYONECANPAY)) {
            $binary = '';
            foreach ($this->tx->getInputs() as $input) {
                $binary .= $this->outpointSerializer->serialize($input->getOutPoint())->getBinary();
            }
            return Hash::sha256d(new Buffer($binary));
        }

        return new Buffer('', 32);
    }

    /**
     * @param int $sighashType
     * @return BufferInterface
     */
    public function hashSequences(int $sighashType): BufferInterface
    {
        if (!($sighashType & SigHash::ANYONECANPAY) && ($sighashType & 0x1f) !== SigHash::SINGLE && ($sighashType & 0x1f) !== SigHash::NONE) {
            $binary = '';
            foreach ($this->tx->getInputs() as $input) {
                $binary .= pack('V', $input->getSequence());
            }

            return Hash::sha256d(new Buffer($binary));
        }

        return new Buffer('', 32);
    }

    /**
     * @param int $sighashType
     * @param int $inputToSign
     * @return BufferInterface
     */
    public function hashOutputs(int $sighashType, int $inputToSign): BufferInterface
    {
        if (($sighashType & 0x1f) !== SigHash::SINGLE && ($sighashType & 0x1f) !== SigHash::NONE) {
            $binary = '';
            foreach ($this->tx->getOutputs() as $output) {
                $binary .= $this->outputSerializer->serialize($output)->getBinary();
            }
            return Hash::sha256d(new Buffer($binary));
        } elseif (($sighashType & 0x1f) === SigHash::SINGLE && $inputToSign < count($this->tx->getOutputs())) {
            return Hash::sha256d($this->outputSerializer->serialize($this->tx->getOutput($inputToSign)));
        }

        return new Buffer('', 32);
    }

    /**
     * Calculate the hash of the current transaction, when you are looking to
     * spend $txOut, and are signing $inputToSign. The SigHashType defaults to
     * SIGHASH_ALL
     *
     * @param ScriptInterface $txOutScript
     * @param int $inputToSign
     * @param int $sighashType
     * @return BufferInterface
     * @throws \Exception
     */
    public function calculate(
        ScriptInterface $txOutScript,
        int $inputToSign,
        int $sighashType = SigHash::ALL
    ): BufferInterface {

        $hashPrevOuts = $this->hashPrevOuts($sighashType);
        $hashSequence = $this->hashSequences($sighashType);
        $hashOutputs = $this->hashOutputs($sighashType, $inputToSign);
        $input = $this->tx->getInput($inputToSign);

        $scriptBuf = $txOutScript->getBuffer();
        $preimage = new Buffer(
            pack("V", $this->tx->getVersion()) .
            $hashPrevOuts->getBinary() .
            $hashSequence->getBinary() .
            $this->outpointSerializer->serialize($input->getOutPoint())->getBinary() .
            Buffertools::numToVarInt($scriptBuf->getSize())->getBinary() . $scriptBuf->getBinary() .
            pack("P", $this->amount) .
            pack("V", $input->getSequence()) .
            $hashOutputs->getBinary() .
            pack("V", $this->tx->getLockTime()) .
            pack("V", $sighashType)
        );

        return Hash::sha256d($preimage);
    }
}
