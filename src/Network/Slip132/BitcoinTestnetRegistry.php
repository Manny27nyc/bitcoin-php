/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Network\Slip132;

use BitWasp\Bitcoin\Key\Deterministic\Slip132\PrefixRegistry;
use BitWasp\Bitcoin\Script\ScriptType;

class BitcoinTestnetRegistry extends PrefixRegistry
{
    public function __construct()
    {
        $map = [];
        foreach ([
                     // private, public
                     [["04358394", "043587cf"], /* xpub */ [ScriptType::P2PKH]],
                     [["04358394", "043587cf"], /* xpub */ [ScriptType::P2SH, ScriptType::P2PKH]],
                     [["044a4e28", "044a5262"], /* ypub */ [ScriptType::P2SH, ScriptType::P2WKH]],
                     [["045f18bc", "045f1cf6"], /* zpub */ [ScriptType::P2WKH]],
                     [["02575048", "02575483"], /* Zpub */ [ScriptType::P2WSH, ScriptType::P2PKH]],
                 ] as $row) {
            list ($prefixList, $scriptType) = $row;
            $type = implode("|", $scriptType);
            $map[$type] = $prefixList;
        }

        parent::__construct($map);
    }
}
