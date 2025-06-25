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

namespace BitWasp\Bitcoin\Serializer\Chain;

use BitWasp\Bitcoin\Chain\BlockLocator;
use BitWasp\Bitcoin\Serializer\Types;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Parser;

class BlockLocatorSerializer
{
    /**
     * @var \BitWasp\Buffertools\Types\VarInt
     */
    private $varint;

    /**
     * @var \BitWasp\Buffertools\Types\ByteString
     */
    private $bytestring32le;

    public function __construct()
    {
        $this->varint = Types::varint();
        $this->bytestring32le = Types::bytestringle(32);
    }

    /**
     * @param Parser $parser
     * @return BlockLocator
     */
    public function fromParser(Parser $parser): BlockLocator
    {
        $numHashes = $this->varint->read($parser);
        $hashes = [];
        for ($i = 0; $i < $numHashes; $i++) {
            $hashes[] = $this->bytestring32le->read($parser);
        }

        $hashStop = $this->bytestring32le->read($parser);

        return new BlockLocator($hashes, $hashStop);
    }

    /**
     * @param BufferInterface $data
     * @return BlockLocator
     */
    public function parse(BufferInterface $data): BlockLocator
    {
        return $this->fromParser(new Parser($data));
    }

    /**
     * @param BlockLocator $blockLocator
     * @return BufferInterface
     * @throws \Exception
     */
    public function serialize(BlockLocator $blockLocator): BufferInterface
    {
        $binary = $this->varint->write(count($blockLocator->getHashes()));
        foreach ($blockLocator->getHashes() as $hash) {
            $binary .= $this->bytestring32le->write($hash);
        }

        $binary .= $this->bytestring32le->write($blockLocator->getHashStop());
        return new Buffer($binary);
    }
}
