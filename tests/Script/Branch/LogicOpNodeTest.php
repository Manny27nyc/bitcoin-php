/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Script\Branch;

use BitWasp\Bitcoin\Script\Path\LogicOpNode;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class LogicOpNodeTest extends AbstractTestCase
{
    public function testGetChildWithNoneThrowsError()
    {
        $logicNode = new LogicOpNode();
        $this->assertFalse($logicNode->hasChildren());
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Child not found");

        $logicNode->getChild(0);
    }

    public function testNodeWontSplitTwice()
    {
        $logicNode = new LogicOpNode();
        $this->assertFalse($logicNode->hasChildren());
        $logicNode->split();

        $this->assertTrue($logicNode->hasChildren());

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Sanity check - don't split twice");

        $logicNode->split();
    }
}
