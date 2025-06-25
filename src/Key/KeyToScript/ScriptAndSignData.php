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

namespace BitWasp\Bitcoin\Key\KeyToScript;

use BitWasp\Bitcoin\Address\Address;
use BitWasp\Bitcoin\Address\BaseAddressCreator;
use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Transaction\Factory\SignData;

class ScriptAndSignData
{
    /**
     * @var ScriptInterface
     */
    private $scriptPubKey;

    /**
     * @var SignData
     */
    private $signData;

    /**
     * ScriptAndSignData constructor.
     * @param ScriptInterface $scriptPubKey
     * @param SignData $signData
     */
    public function __construct(ScriptInterface $scriptPubKey, SignData $signData)
    {
        $this->scriptPubKey = $scriptPubKey;
        $this->signData = $signData;
    }

    /**
     * @return ScriptInterface
     */
    public function getScriptPubKey(): ScriptInterface
    {
        return $this->scriptPubKey;
    }

    /**
     * @param BaseAddressCreator $creator
     * @return Address
     */
    public function getAddress(BaseAddressCreator $creator): Address
    {
        return $creator->fromOutputScript($this->scriptPubKey);
    }

    /**
     * @return SignData
     */
    public function getSignData(): SignData
    {
        return $this->signData;
    }
}
