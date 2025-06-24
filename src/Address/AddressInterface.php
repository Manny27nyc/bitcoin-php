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

namespace BitWasp\Bitcoin\Address;

use BitWasp\Bitcoin\Network\NetworkInterface;
use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Buffertools\BufferInterface;

interface AddressInterface
{
    /**
     * @param NetworkInterface $network
     * @return string
     */
    public function getAddress(NetworkInterface $network = null): string;

    /**
     * @return BufferInterface
     */
    public function getHash(): BufferInterface;

    /**
     * @return ScriptInterface
     */
    public function getScriptPubKey(): ScriptInterface;
}
