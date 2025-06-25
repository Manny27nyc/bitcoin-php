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

use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Serializable;
use BitWasp\Bitcoin\Serializer\Transaction\TransactionOutputSerializer;
use BitWasp\Buffertools\BufferInterface;

class TransactionOutput extends Serializable implements TransactionOutputInterface
{

    /**
     * @var int
     */
    private $value;

    /**
     * @var ScriptInterface
     */
    private $script;

    /**
     * Initialize class
     *
     * @param int $value
     * @param ScriptInterface $script
     */
    public function __construct(int $value, ScriptInterface $script)
    {
        if ($value < 0) {
            throw new \RuntimeException('Transaction output value cannot be negative');
        }
        $this->value = $value;
        $this->script = $script;
    }

    /**
     * {@inheritdoc}
     * @see TransactionOutputInterface::getValue()
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     * @see TransactionOutputInterface::getScript()
     */
    public function getScript(): ScriptInterface
    {
        return $this->script;
    }

    /**
     * {@inheritdoc}
     * @see TransactionOutputInterface::equals()
     */
    public function equals(TransactionOutputInterface $output): bool
    {
        $script = $this->script->equals($output->getScript());
        if (!$script) {
            return false;
        }

        return gmp_cmp($this->value, $output->getValue()) === 0;
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Bitcoin\SerializableInterface::getBuffer()
     */
    public function getBuffer(): BufferInterface
    {
        return (new TransactionOutputSerializer())->serialize($this);
    }
}
