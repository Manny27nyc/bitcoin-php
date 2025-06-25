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

use BitWasp\Buffertools\BufferInterface;

/**
 * @deprecated v2.0.0
 */
class StaticBufferCollection extends StaticCollection
{
    /**
     * @var BufferInterface[]
     */
    protected $set = [];

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * StaticBufferCollection constructor.
     * @param BufferInterface ...$values
     */
    public function __construct(BufferInterface... $values)
    {
        $this->set = $values;
    }

    /**
     * @return BufferInterface
     */
    public function bottom(): BufferInterface
    {
        return parent::bottom();
    }

    /**
     * @return BufferInterface
     */
    public function top(): BufferInterface
    {
        return parent::top();
    }

    /**
     * @return BufferInterface
     */
    public function current(): BufferInterface
    {
        return $this->set[$this->position];
    }

    /**
     * @param int $offset
     * @return BufferInterface
     */
    public function offsetGet($offset)
    {
        if (!array_key_exists($offset, $this->set)) {
            throw new \OutOfRangeException('No offset found');
        }

        return $this->set[$offset];
    }
}
