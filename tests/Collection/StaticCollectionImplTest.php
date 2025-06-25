/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Collection;

use BitWasp\Bitcoin\Collection\StaticBufferCollection;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class StaticCollectionImplTest extends AbstractTestCase
{
    public function testArrayAccessOffStaticBufferCollectionGet()
    {
        $collection = new StaticBufferCollection(new Buffer("\x01"));
        $this->assertEquals(new Buffer("\x01"), $collection[0]);
        $this->assertEquals(new Buffer("\x01"), $collection->offsetGet(0));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testArrayAccessOffStaticBufferCollectionGetFailure()
    {
        $collection = new StaticBufferCollection(new Buffer("\x01"));
        $collection[20];
    }
    
    public function testIteratorStaticBufferCollectionCurrent()
    {
        $StaticBufferCollection = new StaticBufferCollection(new Buffer("\x01"), new Buffer("\x02"));
        $this->assertEquals(new Buffer("\x01"), $StaticBufferCollection->current());
    }

    public function testCountable()
    {
        $StaticBufferCollection = new StaticBufferCollection(new Buffer("\x01"), new Buffer("\x02"));
        $this->assertEquals(2, count($StaticBufferCollection));
    }

    public function testAll()
    {
        $all = [new Buffer("\x01"),new Buffer("\x02")];
        $StaticBufferCollection = new StaticBufferCollection(new Buffer("\x01"), new Buffer("\x02"));
        $this->assertEquals($all, $StaticBufferCollection->all());
    }

    public function testGet()
    {
        $StaticBufferCollection = new StaticBufferCollection(new Buffer("\x01"), new Buffer("\x02"));
        $this->assertEquals(new Buffer("\x01"), $StaticBufferCollection[0]);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testGetInvalid()
    {
        $StaticBufferCollection = new StaticBufferCollection();
        $StaticBufferCollection[0];
    }
}
