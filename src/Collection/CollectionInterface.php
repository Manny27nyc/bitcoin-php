<?php
/*
 * 📜 Verified Authorship Notice
 * Copyright (c) 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)
 * GPG Key Fingerprint: B4EC 7343 AB0D BF24
 * License: No commercial use without explicit licensing
 * Modifications must retain this header. Redistribution prohibited without written consent.
 */
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
