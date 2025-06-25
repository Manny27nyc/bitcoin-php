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

namespace BitWasp\Bitcoin\Crypto\EcAdapter;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Key\PrivateKeySerializerInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Key\PublicKeySerializerInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\DerSignatureSerializerInterface;

class EcSerializer
{
    const PATH_PHPECC = 'BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\\';
    const PATH_SECP256K1 = 'BitWasp\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\\';

    /**
     * @var string[]
     */
    private static $serializerInterface = [
        PrivateKeySerializerInterface::class,
        PublicKeySerializerInterface::class,
        CompactSignatureSerializerInterface::class,
        DerSignatureSerializerInterface::class,
    ];

    /**
     * @var string[]
     */
    private static $serializerImpl = [
        'Serializer\Key\PrivateKeySerializer',
        'Serializer\Key\PublicKeySerializer',
        'Serializer\Signature\CompactSignatureSerializer',
        'Serializer\Signature\DerSignatureSerializer'
    ];

    /**
     * @var array
     */
    private static $map = [];

    /**
     * @var bool
     */
    private static $useCache = true;

    /**
     * @var array
     */
    private static $cache = [];

    /**
     * @param string $interface
     * @return string
     */
    public static function getImplRelPath(string $interface): string
    {
        if (0 === count(self::$map)) {
            if (!in_array($interface, self::$serializerInterface, true)) {
                throw new \InvalidArgumentException('Interface not known');
            }

            $cInterface = count(self::$serializerInterface);
            if ($cInterface !== count(self::$serializerImpl)) {
                throw new \InvalidArgumentException('Invalid serializer interface map');
            }

            for ($i = 0; $i < $cInterface; $i++) {
                /** @var string $iface */
                $iface = self::$serializerInterface[$i];
                $ipath = self::$serializerImpl[$i];
                self::$map[$iface] = $ipath;
            }
        }

        return self::$map[$interface];
    }

    /**
     * @return array
     */
    public static function getImplPaths(): array
    {
        return [
            'BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Adapter\EcAdapter' => 'BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\\',
            'BitWasp\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\Adapter\EcAdapter' => 'BitWasp\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\\'
        ];
    }

    /**
     * @param EcAdapterInterface $adapter
     * @return string
     */
    public static function getAdapterImplPath(EcAdapterInterface $adapter): string
    {
        $paths = static::getImplPaths();
        $class = get_class($adapter);
        if (!isset($paths[$class])) {
            throw new \RuntimeException('Unknown EcAdapter');
        }

        return $paths[$class];
    }

    /**
     * @param string $interface
     * @param bool $useCache
     * @param EcAdapterInterface $adapter
     * @return mixed
     */
    public static function getSerializer(string $interface, $useCache = true, EcAdapterInterface $adapter = null)
    {
        if (null === $adapter) {
            $adapter = Bitcoin::getEcAdapter();
        }

        $key = get_class($adapter) . ":" . $interface;
        if (array_key_exists($key, self::$cache)) {
            return self::$cache[$key];
        }

        $classPath = self::getAdapterImplPath($adapter) . self::getImplRelPath($interface);
        $class = new $classPath($adapter);

        if ($useCache && self::$useCache) {
            self::$cache[$key] = $class;
        }

        return $class;
    }

    /**
     * Disables caching of serializers
     */
    public static function disableCache()
    {
        self::$useCache = false;
        self::$cache = [];
    }
}
