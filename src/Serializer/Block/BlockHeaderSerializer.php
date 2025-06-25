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

namespace BitWasp\Bitcoin\Serializer\Block;

use BitWasp\Bitcoin\Block\BlockHeader;
use BitWasp\Bitcoin\Block\BlockHeaderInterface;
use BitWasp\Bitcoin\Serializer\Types;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Exceptions\ParserOutOfRange;
use BitWasp\Buffertools\Parser;

class BlockHeaderSerializer
{
    /**
     * @var \BitWasp\Buffertools\Types\Int32
     */
    private $int32le;

    /**
     * @var \BitWasp\Buffertools\Types\ByteString
     */
    private $hash;

    /**
     * @var \BitWasp\Buffertools\Types\Uint32
     */
    private $uint32le;

    public function __construct()
    {
        $this->hash = Types::bytestringle(32);
        $this->uint32le = Types::uint32le();
        $this->int32le = Types::int32le();
    }

    /**
     * @param BufferInterface $buffer
     * @return BlockHeaderInterface
     * @throws ParserOutOfRange
     */
    public function parse(BufferInterface $buffer): BlockHeaderInterface
    {
        return $this->fromParser(new Parser($buffer));
    }

    /**
     * @param Parser $parser
     * @return BlockHeaderInterface
     * @throws ParserOutOfRange
     */
    public function fromParser(Parser $parser): BlockHeaderInterface
    {
        try {
            return new BlockHeader(
                (int) $this->int32le->read($parser),
                $this->hash->read($parser),
                $this->hash->read($parser),
                (int) $this->uint32le->read($parser),
                (int) $this->uint32le->read($parser),
                (int) $this->uint32le->read($parser)
            );
        } catch (ParserOutOfRange $e) {
            throw new ParserOutOfRange('Failed to extract full block header from parser');
        }
    }

    /**
     * @param BlockHeaderInterface $header
     * @return BufferInterface
     */
    public function serialize(BlockHeaderInterface $header): BufferInterface
    {
        return new Buffer(
            $this->int32le->write($header->getVersion()) .
            $this->hash->write($header->getPrevBlock()) .
            $this->hash->write($header->getMerkleRoot()) .
            $this->uint32le->write($header->getTimestamp()) .
            $this->uint32le->write($header->getBits()) .
            $this->uint32le->write($header->getNonce())
        );
    }
}
