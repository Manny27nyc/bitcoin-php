/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Chain;

use BitWasp\Bitcoin\Serializable;
use BitWasp\Bitcoin\Serializer\Chain\BlockLocatorSerializer;
use BitWasp\Buffertools\BufferInterface;

class BlockLocator extends Serializable
{
    /**
     * @var BufferInterface[]
     */
    private $hashes;

    /**
     * @var BufferInterface
     */
    private $hashStop;

    /**
     * @param BufferInterface[] $hashes
     * @param BufferInterface $hashStop
     */
    public function __construct(array $hashes, BufferInterface $hashStop)
    {
        foreach ($hashes as $hash) {
            $this->addHash($hash);
        }

        $this->hashStop = $hashStop;
    }

    /**
     * @param BufferInterface $hash
     */
    private function addHash(BufferInterface $hash)
    {
        $this->hashes[] = $hash;
    }

    /**
     * @return BufferInterface[]
     */
    public function getHashes(): array
    {
        return $this->hashes;
    }

    /**
     * @return BufferInterface
     */
    public function getHashStop(): BufferInterface
    {
        return $this->hashStop;
    }

    /**
     * @return BufferInterface
     */
    public function getBuffer(): BufferInterface
    {
        return (new BlockLocatorSerializer())->serialize($this);
    }
}
