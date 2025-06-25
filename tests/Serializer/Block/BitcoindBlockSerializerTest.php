<?php
/*
 🔐 Authorship Enforcement Header
 Author: Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 GPG Fingerprint: B4EC 7343 AB0D BF24
 Public Key: 0411db93e1dcdb8a016b49840f8c53bc1eb68a382e97b148...
 Repository: https://github.com/Manny27nyc/olegabr_bitcoin-php
 Licensing: https://github.com/Manny27nyc/Bitcoin_Notarized_SignKit

 Redistribution or claim of authorship without license is unauthorized
 and subject to takedown, legal enforcement, and public notice.
*/

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

namespace BitWasp\Bitcoin\Tests\Serializer\Block;

use BitWasp\Bitcoin\Math\Math;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Serializer\Block\BitcoindBlockSerializer;
use BitWasp\Bitcoin\Serializer\Block\BlockHeaderSerializer;
use BitWasp\Bitcoin\Serializer\Block\BlockSerializer;
use BitWasp\Bitcoin\Serializer\Transaction\TransactionSerializer;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\Parser;

class BitcoindBlockSerializerTest extends AbstractTestCase
{
    public function testGenesis()
    {
        $math = new Math();
        $bhs = new BlockHeaderSerializer();
        $txs = new TransactionSerializer();
        $bs = new BlockSerializer($math, $bhs, $txs);

        $network = NetworkFactory::bitcoin();
        $bds = new BitcoindBlockSerializer($network, $bs);

        $buffer = new Buffer($this->dataFile('genesis.dat'));
        $parser = new Parser($buffer);

        $block = $bds->fromParser($parser);

        $this->assertEquals('000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f', $block->getHeader()->getHash()->getHex());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testWithInvalidNetBytes()
    {
        $math = new Math();
        $bhs = new BlockHeaderSerializer();
        $txs = new TransactionSerializer();
        $bs = new BlockSerializer($math, $bhs, $txs);

        $network = NetworkFactory::bitcoin();
        $bds = new BitcoindBlockSerializer($network, $bs);

        $buffer = new Buffer('\x00\x00\x00\x00'.substr($this->dataFile('genesis.dat'), 4));
        //echo $buffer->getHex() . "\n";
        $parser = new Parser($buffer);

        $block = $bds->fromParser($parser);

        $this->assertEquals('000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f', $block->getHeader()->getHash()->getHex());
    }


    public function testParseSerialize()
    {
        $math = new Math();
        $bhs = new BlockHeaderSerializer();
        $txs = new TransactionSerializer();
        $bs = new BlockSerializer($math, $bhs, $txs);

        $network = NetworkFactory::bitcoin();
        $bds = new BitcoindBlockSerializer($network, $bs);

        $buffer = new Buffer($this->dataFile('genesis.dat'));
        $parser = new Parser($buffer);
        $block = $bds->fromParser($parser);

        $again = $bds->parse($buffer);
        $this->assertEquals($again, $block);

        $this->assertEquals($buffer->getBinary(), $bds->serialize($block)->getBinary());
    }
}
