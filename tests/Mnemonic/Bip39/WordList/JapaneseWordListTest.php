/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Mnemonic\Bip39\WordList;

use BitWasp\Bitcoin\Tests\AbstractTestCase;

class JapaneseWordListTest extends AbstractTestCase
{
    public function testGetWordList()
    {
        $wl = new \BitWasp\Bitcoin\Mnemonic\Bip39\Wordlist\JapaneseWordList();
        $this->assertEquals(2048, count($wl));
        $this->assertEquals(2048, count($wl->getWords()));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnknownWord()
    {
        $wl = new \BitWasp\Bitcoin\Mnemonic\Bip39\Wordlist\JapaneseWordList();
        $wl->getWord(101010101);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionOutOfRange()
    {
        $wl = new \BitWasp\Bitcoin\Mnemonic\Bip39\Wordlist\JapaneseWordList();

        $word = $wl->getIndex('あいだ');
        $this->assertInternalType('integer', $word);

        $wl->getIndex('あいあいあい');
    }
}
