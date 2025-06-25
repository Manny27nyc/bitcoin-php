/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Address;

use BitWasp\Bitcoin\Network\NetworkInterface;
use BitWasp\Bitcoin\Script\ScriptInterface;

abstract class BaseAddressCreator
{
    /**
     * @param string $strAddress
     * @param NetworkInterface|null $network
     * @return Address
     */
    abstract public function fromString(string $strAddress, NetworkInterface $network = null): Address;

    /**
     * @param ScriptInterface $script
     * @return Address
     */
    abstract public function fromOutputScript(ScriptInterface $script): Address;
}
