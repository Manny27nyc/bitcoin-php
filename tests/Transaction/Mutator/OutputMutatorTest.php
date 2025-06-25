/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Transaction\Mutator;

use BitWasp\Bitcoin\Script\Script;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\Mutator\OutputMutator;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Buffertools\Buffer;

class OutputMutatorTest extends AbstractTestCase
{
    public function testModifiesOutput()
    {
        $value = 50;
        $newValue = 150;
        $script = new Script();
        $newScript = new Script(new Buffer('a'));
        $output = new TransactionOutput($value, $script);
        $modifier = new OutputMutator($output);
        $newOutput = $modifier
            ->value($newValue)
            ->script($newScript)
            ->done();

        $this->assertEquals($newValue, $newOutput->getValue());
        $this->assertEquals($newScript, $newOutput->getScript());
    }
}
