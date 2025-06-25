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

namespace BitWasp\Bitcoin\Script\Parser;

use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Buffertools\BufferInterface;

class Operation
{
    /**
     * @var int[]
     */
    protected static $logical = [
        Opcodes::OP_IF, Opcodes::OP_NOTIF, Opcodes::OP_ELSE, Opcodes::OP_ENDIF,
    ];

    /**
     * @var bool
     */
    private $push;

    /**
     * @var int
     */
    private $opCode;

    /**
     * @var BufferInterface
     */
    private $pushData;

    /**
     * @var int
     */
    private $pushDataSize;

    /**
     * Operation constructor.
     * @param int $opCode
     * @param BufferInterface $pushData
     * @param int $pushDataSize
     */
    public function __construct(int $opCode, BufferInterface $pushData, int $pushDataSize = 0)
    {
        $this->push = $opCode >= 0 && $opCode <= Opcodes::OP_PUSHDATA4;
        $this->opCode = $opCode;
        $this->pushData = $pushData;
        $this->pushDataSize = $pushDataSize;
    }

    /**
     * @return BufferInterface|int
     */
    public function encode()
    {
        if ($this->push) {
            return $this->pushData;
        } else {
            return $this->opCode;
        }
    }

    /**
     * @return bool
     */
    public function isPush(): bool
    {
        return $this->push;
    }

    /**
     * @return bool
     */
    public function isLogical(): bool
    {
        return !$this->isPush() && in_array($this->opCode, self::$logical);
    }


    /**
     * @return int
     */
    public function getOp(): int
    {
        return $this->opCode;
    }

    /**
     * @return BufferInterface
     */
    public function getData(): BufferInterface
    {
        return $this->pushData;
    }

    /**
     * @return int
     */
    public function getDataSize(): int
    {
        if (!$this->push) {
            throw new \RuntimeException("Op wasn't a push operation");
        }

        return $this->pushDataSize;
    }
}
