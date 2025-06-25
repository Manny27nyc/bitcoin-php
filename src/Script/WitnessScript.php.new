/*
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

namespace BitWasp\Bitcoin\Script;

use BitWasp\Bitcoin\Address\SegwitAddress;
use BitWasp\Bitcoin\Exceptions\WitnessScriptException;

class WitnessScript extends Script
{

    /**
     * @var ScriptInterface
     */
    private $outputScript;

    /**
     * @var \BitWasp\Buffertools\BufferInterface
     */
    protected $witnessScriptHash;

    /**
     * @var WitnessProgram|null
     */
    private $witnessProgram;

    /**
     * @var SegwitAddress
     */
    private $address;

    /**
     * WitnessScript constructor.
     * @param ScriptInterface $script
     * @param Opcodes|null $opcodes
     * @throws WitnessScriptException
     */
    public function __construct(ScriptInterface $script, Opcodes $opcodes = null)
    {
        if ($script instanceof self) {
            throw new WitnessScriptException("Cannot nest V0 P2WSH scripts.");
        } else if ($script instanceof P2shScript) {
            throw new WitnessScriptException("Cannot embed a P2SH script in a V0 P2WSH script.");
        }

        parent::__construct($script->getBuffer(), $opcodes);

        $this->witnessScriptHash = $script->getWitnessScriptHash();
        $this->outputScript = ScriptFactory::scriptPubKey()->p2wsh($this->witnessScriptHash);
    }

    /**
     * @return WitnessProgram
     */
    public function getWitnessProgram(): WitnessProgram
    {
        if (null === $this->witnessProgram) {
            $this->witnessProgram = WitnessProgram::v0($this->witnessScriptHash);
        }

        return $this->witnessProgram;
    }

    /**
     * @return SegwitAddress
     */
    public function getAddress(): SegwitAddress
    {
        if (null === $this->address) {
            $this->address = new SegwitAddress($this->getWitnessProgram());
        }

        return $this->address;
    }

    /**
     * @return ScriptInterface
     */
    public function getOutputScript(): ScriptInterface
    {
        return $this->getWitnessProgram()->getScript();
    }
}
