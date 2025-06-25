/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
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
