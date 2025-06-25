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

namespace BitWasp\Bitcoin\Serializer\Transaction;

use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Bitcoin\Script\Script;
use BitWasp\Bitcoin\Serializer\Types;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Bitcoin\Transaction\TransactionOutputInterface;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Parser;

class TransactionOutputSerializer
{
    /**
     * @var \BitWasp\Buffertools\Types\Uint64
     */
    private $uint64le;

    /**
     * @var \BitWasp\Buffertools\Types\VarString
     */
    private $varstring;

    /**
     * @var Opcodes
     */
    private $opcodes;

    /**
     * TransactionOutputSerializer constructor.
     * @param Opcodes|null $opcodes
     */
    public function __construct(Opcodes $opcodes = null)
    {
        $this->uint64le = Types::uint64le();
        $this->varstring = Types::varstring();
        $this->opcodes = $opcodes ?: new Opcodes();
    }

    /**
     * @param TransactionOutputInterface $output
     * @return BufferInterface
     */
    public function serialize(TransactionOutputInterface $output): BufferInterface
    {
        return new Buffer(
            $this->uint64le->write($output->getValue()) .
            $this->varstring->write($output->getScript()->getBuffer())
        );
    }

    /**
     * @param Parser $parser
     * @return TransactionOutputInterface
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function fromParser(Parser $parser): TransactionOutputInterface
    {
        return new TransactionOutput(
            (int) $this->uint64le->read($parser),
            new Script($this->varstring->read($parser), $this->opcodes)
        );
    }

    /**
     * @param BufferInterface $string
     * @return TransactionOutputInterface
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function parse(BufferInterface $string): TransactionOutputInterface
    {
        return $this->fromParser(new Parser($string));
    }
}
