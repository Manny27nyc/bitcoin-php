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

use BitWasp\Bitcoin\Chain\Params;
use BitWasp\Bitcoin\Chain\ProofOfWork;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class DifficultyTest extends AbstractTestCase
{

    public function getLowestBits()
    {
        return 0x1d00ffff;
    }

    public function testGetWork()
    {
        $vectors = [
            [
                0x1d00ffff,
                '4295032833'
            ]
        ];

        $math = $this->safeMath();
        $params = new Params($math);
        $difficulty = new ProofOfWork($math, $params);

        foreach ($vectors as $v) {
            $this->assertEquals($v[1], $math->toString($difficulty->getWork($v[0])));
        }
    }

    public function testGetTarget()
    {
        $json = json_decode($this->dataFile('difficulty.json'));

        $math = $this->safeMath();
        $params = new Params($math);
        $difficulty = new ProofOfWork($math, $params);
        foreach ($json->test as $test) {
            $bits = hexdec($test->bits);

            $this->assertEquals($test->targetHash, $difficulty->getTargetHash($bits)->getHex());
            $this->assertEquals($test->difficulty, $difficulty->getDifficulty($bits));
        }
    }
}
