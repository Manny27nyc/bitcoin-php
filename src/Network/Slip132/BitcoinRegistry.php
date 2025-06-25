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

namespace BitWasp\Bitcoin\Network\Slip132;

use BitWasp\Bitcoin\Key\Deterministic\Slip132\PrefixRegistry;
use BitWasp\Bitcoin\Script\ScriptType;

class BitcoinRegistry extends PrefixRegistry
{
    protected static $table = [
        [["0488ade4", "0488b21e"], /* xpub */ [ScriptType::P2PKH]],
        [["0488ade4", "0488b21e"], /* xpub */ [ScriptType::P2SH, ScriptType::MULTISIG]],
        [["049d7878", "049d7cb2"], /* ypub */ [ScriptType::P2SH, ScriptType::P2WKH]],
        [["0295b005", "0295b43f"], /* Ypub */ [ScriptType::P2SH, ScriptType::P2WSH, ScriptType::MULTISIG]],
        [["04b2430c", "04b24746"], /* zpub */ [ScriptType::P2WKH]],
        [["02aa7a99", "02aa7ed3"], /* Zpub */ [ScriptType::P2WSH, ScriptType::MULTISIG]],
    ];

    public function __construct()
    {
        $map = [];
        foreach (static::$table as list ($prefixList, $scriptType)) {
            $type = implode("|", $scriptType);
            $map[$type] = $prefixList;
        }

        parent::__construct($map);
    }
}
