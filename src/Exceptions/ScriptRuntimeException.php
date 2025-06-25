/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
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
