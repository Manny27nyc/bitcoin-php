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

namespace BitWasp\Bitcoin\Script\Path;

use BitWasp\Bitcoin\Script\Interpreter\Stack;
use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Bitcoin\Script\ScriptInterface;

class BranchInterpreter
{

    /**
     * @var array
     */
    private $disabledOps = [
        Opcodes::OP_CAT,    Opcodes::OP_SUBSTR, Opcodes::OP_LEFT,  Opcodes::OP_RIGHT,
        Opcodes::OP_INVERT, Opcodes::OP_AND,    Opcodes::OP_OR,    Opcodes::OP_XOR,
        Opcodes::OP_2MUL,   Opcodes::OP_2DIV,   Opcodes::OP_MUL,   Opcodes::OP_DIV,
        Opcodes::OP_MOD,    Opcodes::OP_LSHIFT, Opcodes::OP_RSHIFT
    ];

    /**
     * @param ScriptInterface $script
     * @return ParsedScript
     */
    public function getScriptTree(ScriptInterface $script): ParsedScript
    {
        $ast = $this->getAstForLogicalOps($script);
        $scriptPaths = $ast->flags();

        $scriptBranches = [];
        if (count($scriptPaths) > 1) {
            foreach ($scriptPaths as $path) {
                $scriptBranches[] = $this->getBranchForPath($script, $path);
            }
        } else {
            $scriptBranches[] = $this->getBranchForPath($script, []);
        }

        return new ParsedScript($script, $ast, $scriptBranches);
    }

    /**
     * Build tree of dependent logical ops
     * @param ScriptInterface $script
     * @return LogicOpNode
     */
    public function getAstForLogicalOps(ScriptInterface $script): LogicOpNode
    {
        $root = new LogicOpNode(null);
        $current = $root;

        foreach ($script->getScriptParser()->decode() as $op) {
            switch ($op->getOp()) {
                case Opcodes::OP_IF:
                case Opcodes::OP_NOTIF:
                    $split = $current->split();
                    $current = $split[$op->getOp() & 1];
                    break;
                case Opcodes::OP_ENDIF:
                    if (null === $current->getParent()) {
                        throw new \RuntimeException("Unexpected ENDIF, current scope had no parent");
                    }
                    $current = $current->getParent();
                    break;
                case Opcodes::OP_ELSE:
                    if (null === $current->getParent()) {
                        throw new \RuntimeException("Unexpected ELSE, current scope had no parent");
                    }
                    $current = $current->getParent()->getChild((int) !$current->getValue());
                    break;
            }
        }

        if (!$current->isRoot()) {
            throw new \RuntimeException("Unbalanced conditional - vfStack not empty at script termination");
        }

        return $root;
    }

    /**
     * Given a script and path, attempt to produce a ScriptBranch instance
     *
     * @param ScriptInterface $script
     * @param bool[] $path
     * @return ScriptBranch
     */
    public function getBranchForPath(ScriptInterface $script, array $path): ScriptBranch
    {
        // parses the opcodes which were actually run
        $segments = $this->evaluateUsingStack($script, $path);

        return new ScriptBranch($script, $path, $segments);
    }

    /**
     * @param Stack $vfStack
     * @param bool $value
     * @return bool
     */
    private function checkExec(Stack $vfStack, bool $value): bool
    {
        $ret = 0;
        foreach ($vfStack as $item) {
            if ($item === $value) {
                $ret++;
            }
        }

        return (bool) $ret;
    }

    /**
     * @param ScriptInterface $script
     * @param int[] $logicalPath
     * @return array - array of Operation[] representing script segments
     */
    public function evaluateUsingStack(ScriptInterface $script, array $logicalPath): array
    {
        $mainStack = new Stack();
        foreach (array_reverse($logicalPath) as $setting) {
            $mainStack->push($setting);
        }

        $vfStack = new Stack();
        $parser = $script->getScriptParser();
        $tracer = new PathTracer();

        foreach ($parser as $i => $operation) {
            $opCode = $operation->getOp();
            $fExec = !$this->checkExec($vfStack, false);

            if (in_array($opCode, $this->disabledOps, true)) {
                throw new \RuntimeException('Disabled Opcode');
            }

            if (Opcodes::OP_IF <= $opCode && $opCode <= Opcodes::OP_ENDIF) {
                switch ($opCode) {
                    case Opcodes::OP_IF:
                    case Opcodes::OP_NOTIF:
                        // <expression> if [statements] [else [statements]] endif
                        $value = false;
                        if ($fExec) {
                            if ($mainStack->isEmpty()) {
                                $op = $script->getOpcodes()->getOp($opCode & 1 ? Opcodes::OP_IF : Opcodes::OP_NOTIF);
                                throw new \RuntimeException("Unbalanced conditional at {$op} - not included in logicalPath");
                            }

                            $value = $mainStack->pop();
                            if ($opCode === Opcodes::OP_NOTIF) {
                                $value = !$value;
                            }
                        }
                        $vfStack->push($value);
                        break;

                    case Opcodes::OP_ELSE:
                        if ($vfStack->isEmpty()) {
                            throw new \RuntimeException('Unbalanced conditional at OP_ELSE');
                        }
                        $vfStack->push(!$vfStack->pop());
                        break;

                    case Opcodes::OP_ENDIF:
                        if ($vfStack->isEmpty()) {
                            throw new \RuntimeException('Unbalanced conditional at OP_ENDIF');
                        }
                        $vfStack->pop();

                        break;
                }

                $tracer->operation($operation);
            } else if ($fExec) {
                // Fill up trace with executed opcodes
                $tracer->operation($operation);
            }
        }

        if (count($vfStack) !== 0) {
            throw new \RuntimeException('Unbalanced conditional at script end');
        }

        if (count($mainStack) !== 0) {
            throw new \RuntimeException('Values remaining after script execution - invalid branch data');
        }

        return $tracer->done();
    }
}
