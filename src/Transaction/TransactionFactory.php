<?php
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

use BitWasp\Bitcoin\Serializer\Transaction\TransactionSerializer;
use BitWasp\Bitcoin\Transaction\Factory\TxBuilder;
use BitWasp\Bitcoin\Transaction\Mutator\TxMutator;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class TransactionFactory
{
    /**
     * @return TxBuilder
     */
    public static function build(): TxBuilder
    {
        return new TxBuilder();
    }

    /**
     * @param TransactionInterface $transaction
     * @return TxMutator
     */
    public static function mutate(TransactionInterface $transaction): TxMutator
    {
        return new TxMutator($transaction);
    }

    /**
     * @param string $hex
     * @return TransactionInterface
     * @throws \Exception
     */
    public static function fromHex(string $hex): TransactionInterface
    {
        return self::fromBuffer(Buffer::hex($hex));
    }

    /**
     * @param BufferInterface $buffer
     * @return TransactionInterface
     */
    public static function fromBuffer(BufferInterface $buffer): TransactionInterface
    {
        return (new TransactionSerializer())->parse($buffer);
    }
}
