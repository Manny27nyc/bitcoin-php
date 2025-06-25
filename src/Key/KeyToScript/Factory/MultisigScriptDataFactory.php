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

namespace BitWasp\Bitcoin\Key\KeyToScript\Factory;

use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Key\PublicKeySerializerInterface;
use BitWasp\Bitcoin\Key\KeyToScript\ScriptAndSignData;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\ScriptType;
use BitWasp\Bitcoin\Transaction\Factory\SignData;

class MultisigScriptDataFactory extends KeyToScriptDataFactory
{
    /**
     * @var int
     */
    private $numSigners;

    /**
     * @var int
     */
    private $numKeys;

    /**
     * @var bool
     */
    private $sortKeys;

    public function __construct(int $numSigners, int $numKeys, bool $sortKeys, PublicKeySerializerInterface $pubKeySerializer = null)
    {
        $this->numSigners = $numSigners;
        $this->numKeys = $numKeys;
        $this->sortKeys = $sortKeys;
        parent::__construct($pubKeySerializer);
    }

    /**
     * @return string
     */
    public function getScriptType(): string
    {
        return ScriptType::MULTISIG;
    }

    /**
     * @param PublicKeyInterface ...$keys
     * @return ScriptAndSignData
     */
    protected function convertKeyToScriptData(PublicKeyInterface ...$keys): ScriptAndSignData
    {
        if (count($keys) !== $this->numKeys) {
            throw new \InvalidArgumentException("Incorrect number of keys");
        }

        $keyBuffers = [];
        for ($i = 0; $i < $this->numKeys; $i++) {
            $keyBuffers[] = $this->pubKeySerializer->serialize($keys[$i]);
        }

        return new ScriptAndSignData(
            ScriptFactory::scriptPubKey()->multisigKeyBuffers($this->numSigners, $keyBuffers, $this->sortKeys),
            new SignData()
        );
    }
}
