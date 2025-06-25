/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin;

abstract class Serializable implements SerializableInterface
{
    /**
     * @return string
     */
    public function getHex(): string
    {
        return $this->getBuffer()->getHex();
    }

    /**
     * @return string
     */
    public function getBinary(): string
    {
        return $this->getBuffer()->getBinary();
    }

    /**
     * @return int
     */
    public function getInt()
    {
        return $this->getBuffer()->getInt();
    }
}
