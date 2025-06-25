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

namespace BitWasp\Bitcoin\Transaction\Mutator;

use BitWasp\Bitcoin\Transaction\TransactionOutputInterface;

class OutputCollectionMutator extends AbstractCollectionMutator
{
    /**
     * @param TransactionOutputInterface[] $outputs
     */
    public function __construct(array $outputs)
    {
        /** @var OutputMutator[] $set */
        $this->set = new \SplFixedArray(count($outputs));
        foreach ($outputs as $i => $output) {
            /** @var int $i */
            $this->set[$i] = new OutputMutator($output);
        }
    }

    /**
     * @return OutputMutator
     */
    public function current(): OutputMutator
    {
        return $this->set->current();
    }

    /**
     * @param int $offset
     * @return OutputMutator
     */
    public function offsetGet($offset): OutputMutator
    {
        if (!$this->set->offsetExists($offset)) {
            throw new \OutOfRangeException('Nothing found at this offset');
        }

        return $this->set->offsetGet($offset);
    }

    /**
     * @return TransactionOutputInterface[]
     */
    public function done(): array
    {
        $set = [];
        foreach ($this->set as $mutator) {
            $set[] = $mutator->done();
        }

        return $set;
    }

    /**
     * @param int $start
     * @param int $length
     * @return $this
     */
    public function slice(int $start, int $length)
    {
        $end = count($this->set);
        if ($start > $end || $length > $end) {
            throw new \RuntimeException('Invalid start or length');
        }

        $this->set = \SplFixedArray::fromArray(array_slice($this->set->toArray(), $start, $length), false);
        return $this;
    }

    /**
     * @return $this
     */
    public function null()
    {
        $this->slice(0, 0);
        return $this;
    }

    /**
     * @param TransactionOutputInterface $output
     * @return $this
     */
    public function add(TransactionOutputInterface $output)
    {
        $size = $this->set->getSize();
        $this->set->setSize($size + 1);

        $this->set[$size] = new OutputMutator($output);
        return $this;
    }

    /**
     * @param int $i
     * @param TransactionOutputInterface $output
     * @return $this
     */
    public function set($i, TransactionOutputInterface $output)
    {
        $this->set[$i] = new OutputMutator($output);
        return $this;
    }
}
