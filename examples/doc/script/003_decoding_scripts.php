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

use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Bitcoin\Script\ScriptFactory;

require __DIR__ . "/../../../vendor/autoload.php";

$scriptPubKey = ScriptFactory::create()->int(1)->opcode(Opcodes::OP_ADD)->int(2)->opcode(Opcodes::OP_EQUAL)->getScript();
$opcodes = $scriptPubKey->getOpcodes();

foreach ($scriptPubKey->getScriptParser()->decode() as $operation) {
    if ($operation->isPush()) {
        echo "push [{$operation->getData()}]\n";
    } else {
        echo "op [{$opcodes->getOp($operation->getOp())}]\n";
    }
}
