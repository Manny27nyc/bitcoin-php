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
