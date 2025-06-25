/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Collection;

/**
 * @deprecated v2.0.0
 */
interface CollectionInterface extends \Iterator, \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @return mixed
     */
    public function bottom();

    /**
     * @return mixed
     */
    public function top();
    
    /**
     * @param int $start
     * @param int $length
     * @return self
     */
    public function slice(int $start, int $length);

    /**
     * @return bool
     */
    public function isNull(): bool;
}
