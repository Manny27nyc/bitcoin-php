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

namespace BitWasp\Bitcoin\Tests\Key\Deterministic\HdPrefix;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\GlobalPrefixConfig;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\NetworkConfig;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class GlobalPrefixConfigTest extends AbstractTestCase
{
    public function testInvalidArray()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("expecting array of NetworkPrefixConfig");

        new GlobalPrefixConfig([
            Bitcoin::getNetwork()
        ]);
    }

    public function testDuplicateNetworksNotAllowed()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("multiple configs for network");

        new GlobalPrefixConfig([
            new NetworkConfig(NetworkFactory::bitcoin(), []),
            new NetworkConfig(NetworkFactory::bitcoin(), []),
        ]);
    }

    public function testMultipleNetworksWorks()
    {
        $btc = NetworkFactory::bitcoin();
        $btcConfig = new NetworkConfig($btc, []);
        $tbtc = NetworkFactory::bitcoinTestnet();
        $tbtcConfig = new NetworkConfig($tbtc, []);
        $config = new GlobalPrefixConfig([
            $btcConfig,
            $tbtcConfig,
        ]);

        $this->assertSame($btcConfig, $config->getNetworkConfig($btc));
        $this->assertSame($tbtcConfig, $config->getNetworkConfig($tbtc));
    }

    public function testUnknownNetwork()
    {
        $btc = NetworkFactory::bitcoin();
        $btcConfig = new NetworkConfig($btc, []);
        $tbtc = NetworkFactory::bitcoinTestnet();
        $config = new GlobalPrefixConfig([
            $btcConfig,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Network not registered with GlobalHdPrefixConfig");

        $config->getNetworkConfig($tbtc);
    }
}
