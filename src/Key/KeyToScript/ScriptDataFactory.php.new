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

namespace BitWasp\Bitcoin\Key\KeyToScript;

use BitWasp\Bitcoin\Crypto\EcAdapter\Key\KeyInterface;

abstract class ScriptDataFactory
{
    /**
     * @param KeyInterface ...$keys
     * @return ScriptAndSignData
     */
    abstract public function convertKey(KeyInterface ...$keys): ScriptAndSignData;

    /**
     * @return string
     */
    abstract public function getScriptType(): string;
}
