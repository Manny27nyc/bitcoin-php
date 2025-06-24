/*
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

namespace BitWasp\Bitcoin\Tests\Key\KeyToScript\Decorator;

use BitWasp\Bitcoin\Exceptions\DisallowedScriptDataFactoryException;
use BitWasp\Bitcoin\Key\KeyToScript\Decorator\P2shP2wshScriptDecorator;
use BitWasp\Bitcoin\Key\KeyToScript\Factory\KeyToScriptDataFactory;
use BitWasp\Bitcoin\Key\KeyToScript\Factory\P2pkhScriptDataFactory;
use BitWasp\Bitcoin\Key\KeyToScript\Factory\P2pkScriptDataFactory;
use BitWasp\Bitcoin\Key\KeyToScript\Factory\P2wpkhScriptDataFactory;
use BitWasp\Bitcoin\Script\ScriptType;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class NestedP2shP2wshScriptDecoratorTest extends AbstractTestCase
{
    public function getAllowedScriptFactories()
    {
        return [
            [new P2pkhScriptDataFactory()],
            [new P2pkScriptDataFactory()],
        ];
    }

    /**
     * @dataProvider getAllowedScriptFactories
     * @param KeyToScriptDataFactory $factory
     * @throws \BitWasp\Bitcoin\Exceptions\DisallowedScriptDataFactoryException
     */
    public function testAllowedScriptType(KeyToScriptDataFactory $factory)
    {
        $p2shFactory = new P2shP2wshScriptDecorator($factory);
        $this->assertEquals(ScriptType::P2SH . "|" . ScriptType::P2WSH . "|" . $factory->getScriptType(), $p2shFactory->getScriptType());
    }

    public function testNotAllowed()
    {
        $this->expectException(DisallowedScriptDataFactoryException::class);
        new P2shP2wshScriptDecorator(new P2wpkhScriptDataFactory());
    }
}
