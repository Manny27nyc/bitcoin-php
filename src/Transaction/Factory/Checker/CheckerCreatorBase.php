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

namespace BitWasp\Bitcoin\Transaction\Factory\Checker;

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Key\PublicKeySerializerInterface;
use BitWasp\Bitcoin\Script\Interpreter\CheckerBase;
use BitWasp\Bitcoin\Serializer\Signature\TransactionSignatureSerializer;
use BitWasp\Bitcoin\Transaction\TransactionInterface;
use BitWasp\Bitcoin\Transaction\TransactionOutputInterface;

abstract class CheckerCreatorBase
{
    /**
     * @var EcAdapterInterface
     */
    protected $ecAdapter;

    /**
     * @var TransactionSignatureSerializer
     */
    protected $txSigSerializer;

    /**
     * @var PublicKeySerializerInterface
     */
    protected $pubKeySerializer;

    /**
     * CheckerCreator constructor.
     * @param EcAdapterInterface $ecAdapter
     * @param TransactionSignatureSerializer $txSigSerializer
     * @param PublicKeySerializerInterface $pubKeySerializer
     */
    public function __construct(
        EcAdapterInterface $ecAdapter,
        TransactionSignatureSerializer $txSigSerializer,
        PublicKeySerializerInterface $pubKeySerializer
    ) {
        $this->ecAdapter = $ecAdapter;
        $this->txSigSerializer = $txSigSerializer;
        $this->pubKeySerializer = $pubKeySerializer;
    }

    /**
     * @param TransactionInterface $tx
     * @param int $nInput
     * @param TransactionOutputInterface $txOut
     * @return CheckerBase
     */
    abstract public function create(TransactionInterface $tx, int $nInput, TransactionOutputInterface $txOut): CheckerBase;
}
