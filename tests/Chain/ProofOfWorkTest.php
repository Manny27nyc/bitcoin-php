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

namespace BitWasp\Bitcoin\Tests\Chain;

use BitWasp\Bitcoin\Block\BlockHeader;
use BitWasp\Bitcoin\Block\BlockHeaderInterface;
use BitWasp\Bitcoin\Chain\Params;
use BitWasp\Bitcoin\Chain\ProofOfWork;
use BitWasp\Bitcoin\Math\Math;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class ProofOfWorkTest extends AbstractTestCase
{

    public function getHistoricData()
    {
        $math = $this->safeMath();
        $params = new Params($math);
        $pow = new ProofOfWork(new Math(), $params);
        $data = json_decode($this->dataFile('pow'), true);

        $results = [];
        foreach ($data as $c => $record) {
            list ($height, $hash, $version, $prev, $merkle, $time, $bits, $nonce) = $record;
            $header = new BlockHeader($version, Buffer::hex($prev, 32), Buffer::hex($merkle, 32), (int) $time, (int) Buffer::hex($bits)->getInt(), (int) $nonce);
            $results[] = [$pow, $height, $hash, $header];
        }

        return $results;
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage nBits below minimum work
     */
    public function testWhereBitsBelowMinimum()
    {
        $math = $this->safeMath();
        $params = new Params($math);
        $pow = new ProofOfWork(new Math(), $params);
        $bits = 1;
        $pow->checkPow(Buffer::hex('00000000a3bbe4fd1da16a29dbdaba01cc35d6fc74ee17f794cf3aab94f7aaa0'), $bits);
    }

    public function testWhereHashTooLow()
    {
        $math = new Math();
        $params = new Params($math);
        $pow = new ProofOfWork(new Math(), $params);
        $bits = 0x181287ba;
        $this->assertFalse($pow->checkPow(Buffer::hex('00000000a3bbe4fd1da16a29dbdaba01cc35d6fc74ee17f794cf3aab94f7aaa0'), $bits));
    }

    /**
     * @dataProvider getHistoricData
     * @param ProofOfWork $pow
     * @param int $height
     * @param string $hash
     * @param BlockHeaderInterface $header
     */
    public function testHistoric(ProofOfWork $pow, $height, $hash, BlockHeaderInterface $header)
    {
        $this->assertTrue($pow->checkHeader($header));
    }
}
