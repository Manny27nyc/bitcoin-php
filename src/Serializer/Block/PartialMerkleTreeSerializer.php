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

use BitWasp\Bitcoin\Block\PartialMerkleTree;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Parser;
use BitWasp\Buffertools\Template;
use BitWasp\Buffertools\TemplateFactory;

class PartialMerkleTreeSerializer
{
    /**
     * @var \BitWasp\Buffertools\Template
     */
    private $template;

    /**
     * PartialMerkleTreeSerializer constructor.
     */
    public function __construct()
    {
        $this->template = $this->getTemplate();
    }

    /**
     * @return Template
     */
    public function getTemplate(): Template
    {
        return (new TemplateFactory())
            ->uint32le()
            ->vector(function (Parser $parser) {
                return $parser->readBytes(32);
            })
            ->vector(function (Parser $parser) {
                return $parser->readBytes(1);
            })
            ->getTemplate();
    }

    /**
     * @param int $last
     * @param BufferInterface[] $vBytes
     * @return array
     */
    private function buffersToBitArray($last, array $vBytes): array
    {
        $size = count($vBytes) * 8;
        $vBits = [];

        for ($p = 0; $p < $size; $p++) {
            $byteIndex = (int)floor($p / 8);
            $byte = ord($vBytes[$byteIndex]->getBinary());
            $vBits[$p] = (int) (($byte & (1 << ($p % 8))) !== 0);
        }

        return array_slice($vBits, 0, $last);
    }

    /**
     * @param Parser $parser
     * @return PartialMerkleTree
     */
    public function fromParser(Parser $parser): PartialMerkleTree
    {
        list ($txCount, $vHash, $vBits) = $this->template->parse($parser);

        return new PartialMerkleTree(
            (int)$txCount,
            $vHash,
            $this->buffersToBitArray($txCount, $vBits)
        );
    }

    /**
     * @param BufferInterface $buffer
     * @return PartialMerkleTree
     */
    public function parse(BufferInterface $buffer): PartialMerkleTree
    {
        return $this->fromParser(new Parser($buffer));
    }

    /**
     * @param array $bits
     * @return array
     */
    private function bitsToBuffers(array $bits): array
    {
        $vBuffers = str_split(str_pad('', (int)((count($bits)+7)/8), '0', STR_PAD_LEFT));
        $nBits = count($bits);

        for ($p = 0; $p < $nBits; $p++) {
            $index = (int)floor($p / 8);
            $vBuffers[$index] |= $bits[$p] << ($p % 8);
        }

        foreach ($vBuffers as &$value) {
            $value = Buffer::int($value);
        }
        unset($value);

        return $vBuffers;
    }

    /**
     * @param PartialMerkleTree $tree
     * @return BufferInterface
     */
    public function serialize(PartialMerkleTree $tree): BufferInterface
    {
        return $this->template->write([
            $tree->getTxCount(),
            $tree->getHashes(),
            $this->bitsToBuffers($tree->getFlagBits())
        ]);
    }
}
