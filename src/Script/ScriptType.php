/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Script;

class ScriptType
{
    const P2PK = 'pubkey';
    const P2PKH = 'pubkeyhash';
    const MULTISIG = 'multisig';
    const NULLDATA = 'nulldata';
    const P2SH = 'scripthash';
    const P2WSH = 'witness_v0_scripthash';
    const P2WKH = 'witness_v0_keyhash';
    const WITNESS_COINBASE_COMMITMENT = 'witness_coinbase_commitment';
    const NONSTANDARD = 'nonstandard';
}
