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

namespace BitWasp\Bitcoin\Key\Deterministic\HdPrefix;

use BitWasp\Bitcoin\Network\NetworkInterface;

class GlobalPrefixConfig
{
    /**
     * @var NetworkConfig[]
     */
    private $networkConfigs = [];

    /**
     * ScriptPrefixConfig constructor.
     * @param NetworkConfig[] $config
     */
    public function __construct(array $config)
    {
        foreach ($config as $networkPrefixConfig) {
            if (!($networkPrefixConfig instanceof NetworkConfig)) {
                throw new \InvalidArgumentException("expecting array of NetworkPrefixConfig");
            }

            $networkClass = get_class($networkPrefixConfig->getNetwork());
            if (array_key_exists($networkClass, $this->networkConfigs)) {
                throw new \InvalidArgumentException("multiple configs for network");
            }

            $this->networkConfigs[$networkClass] = $networkPrefixConfig;
        }
    }

    /**
     * @param NetworkInterface $network
     * @return NetworkConfig
     */
    public function getNetworkConfig(NetworkInterface $network): NetworkConfig
    {
        $class = get_class($network);
        if (!array_key_exists($class, $this->networkConfigs)) {
            throw new \InvalidArgumentException("Network not registered with GlobalHdPrefixConfig");
        }

        return $this->networkConfigs[$class];
    }
}
