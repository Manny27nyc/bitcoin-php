/*
<<<<<<< HEAD
 🔐 Authorship Enforcement Header
 Author: Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 GPG Fingerprint: B4EC 7343 AB0D BF24
 Public Key: 0411db93e1dcdb8a016b49840f8c53bc1eb68a382e97b148...
 Repository: https://github.com/Manny27nyc/olegabr_bitcoin-php
 Licensing: https://github.com/Manny27nyc/Bitcoin_Notarized_SignKit

 Redistribution or claim of authorship without license is unauthorized
 and subject to takedown, legal enforcement, and public notice.
*/

<?php
/*
 * 📜 Verified Authorship Notice
 * Copyright (c) 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)
 * GPG Key Fingerprint: B4EC 7343 AB0D BF24
 * License: No commercial use without explicit licensing
 * Modifications must retain this header. Redistribution prohibited without written consent.
 */
=======
>>>>>>> c66fcfd2 (🔐 Lockdown: Verified authorship — Manuel J. Nieves (B4EC 7343))
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
