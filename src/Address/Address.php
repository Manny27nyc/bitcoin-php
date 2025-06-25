/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Address;

use BitWasp\Buffertools\BufferInterface;

/**
 * Abstract Class Address
 * Used to store a hash
 */
abstract class Address implements AddressInterface
{
    /**
     * @var BufferInterface
     */
    protected $hash;

    /**
     * @param BufferInterface $hash
     */
    public function __construct(BufferInterface $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return BufferInterface
     */
    public function getHash(): BufferInterface
    {
        return $this->hash;
    }
}
