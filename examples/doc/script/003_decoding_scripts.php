/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
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
