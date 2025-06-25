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

namespace BitWasp\Bitcoin\Tests\Signature;

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Adapter\EcAdapter as PhpeccAdapter;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Signature\Signature;
use BitWasp\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;
use BitWasp\Bitcoin\Signature\SignatureFactory;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

/**
 * Class SignatureTest
 * @package Bitcoin
 */
class SignatureTest extends AbstractTestCase
{
    /**
     * @var string
     */
    protected $sigType = SignatureInterface::class;

    public function getPhpEcc()
    {
        return new PhpeccAdapter($this->safeMath(), $this->safeGenerator());
    }

    public function testCreatesSignature()
    {
        $r = gmp_init('15148391597642804072346119047125209977057190235171731969261106466169304622925', 10);
        $s = gmp_init('29241524176690745465970782157695275252863180202254265092780741319779241938696', 10);
        $sig = new Signature($this->getPhpEcc(), $r, $s);
        $this->assertInstanceOf($this->sigType, $sig);
        $this->assertSame($r, $sig->getR());
        $this->assertSame($s, $sig->getS());
    }

    public function testSerialize()
    {
        $r = gmp_init('56860522993476239843569407076292679822350064328987049204205911586688428093823', 10);
        $s = gmp_init('75328468267675219166053001951181042681597800329127462438170420074748074627387', 10);
        $sig = new Signature($this->getPhpEcc(), $r, $s);
        $this->assertInstanceOf($this->sigType, $sig);
        $this->assertEquals('304502207db5ea602fe2e9f8e70bfc68b7f468d68910d2ff4ac50294fc80109e254f317f022100a68a66f23406fdfd93025c28ffef4e79260283335ce39a4e8d0b52c5ee41913b', $sig->getHex());
    }

    /**
     * @dataProvider getEcAdapters
     * @param EcAdapterInterface $ecAdapter
     */
    public function testFromHex(EcAdapterInterface $ecAdapter)
    {

        $hex = '304502207db5ea602fe2e9f8e70bfc68b7f468d68910d2ff4ac50294fc80109e254f317f022100a68a66f23406fdfd93025c28ffef4e79260283335ce39a4e8d0b52c5ee41913b';
        $sig = SignatureFactory::fromHex($hex, $ecAdapter);

        $this->assertInstanceOf($this->sigType, $sig);
        $this->assertEquals('56860522993476239843569407076292679822350064328987049204205911586688428093823', gmp_strval($sig->getR(), 10));
        $this->assertEquals('75328468267675219166053001951181042681597800329127462438170420074748074627387', gmp_strval($sig->getS(), 10));
    }
}
