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

namespace BitWasp\Bitcoin\RpcTest;

class RpcCredential
{
    const CONFIG_TEMPLATE = <<<EOF
rpcuser=%s
rpcpassword=%s
rpcport=%d
rpcallowip=127.0.0.1
server=1
daemon=1
regtest=1
EOF;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $isHttps;

    /**
     * RpcCredential constructor.
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $pass
     * @param bool $isHttps
     */
    public function __construct(string $host, int $port, string $user, string $pass, bool $isHttps)
    {
        $this->host = $host;
        $this->username = $user;
        $this->port = $port;
        $this->password = $pass;
        $this->isHttps = $isHttps;
    }

    /**
     * @return array
     */
    public function getConfigArray(): array
    {
        return [
            "rpcuser" => $this->username,
            "rpcpassword" => $this->password,
            "rpcport" => $this->port,
            "rpcallowip" => "127.0.0.1",
        ];
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        $prefix = "http" . ($this->isHttps ? "s" : "");
        return "$prefix://{$this->username}:{$this->password}@{$this->host}:{$this->port}";
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isHttps(): bool
    {
        return $this->isHttps;
    }
}
