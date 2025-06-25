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

abstract class AbstractCollectionMutator implements \Iterator, \ArrayAccess, \Countable
{
    /**
     * @var \SplFixedArray
     */
    protected $set;

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->set->toArray();
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return count($this->set) === 0;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->set->count();
    }

    /**
     *
     */
    public function rewind()
    {
        $this->set->rewind();
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->set->current();
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->set->key();
    }

    /**
     *
     */
    public function next()
    {
        $this->set->next();
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->set->valid();
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->set->offsetExists($offset);
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \InvalidArgumentException('Offset does not exist');
        }

        $this->set->offsetUnset($offset);
    }

    /**
     * @param int $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (!$this->set->offsetExists($offset)) {
            throw new \OutOfRangeException('Nothing found at this offset');
        }
        return $this->set->offsetGet($offset);
    }

    /**
     * @param int $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set->offsetSet($offset, $value);
    }
}
