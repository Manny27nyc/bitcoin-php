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

namespace BitWasp\Bitcoin\Exceptions;

class ScriptRuntimeException extends \Exception
{
    /**
     * @var int|string
     */
    private $failureFlag;

    /**
     * @param int|string $failureFlag
     * @param string $message
     */
    public function __construct($failureFlag, $message)
    {
        $this->failureFlag = $failureFlag;
        parent::__construct($message);
    }

    /**
     * var int|string
     */
    public function getFailureFlag()
    {
        return $this->failureFlag;
    }
}
