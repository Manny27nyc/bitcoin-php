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

use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Transaction\OutPoint;
use BitWasp\Bitcoin\Transaction\OutPointInterface;
use BitWasp\Bitcoin\Transaction\TransactionInput;
use BitWasp\Bitcoin\Transaction\TransactionInputInterface;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class InputMutator
{
    /**
     * @var TransactionInputInterface
     */
    private $input;

    /**
     * @param TransactionInputInterface $input
     */
    public function __construct(TransactionInputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * @return TransactionInputInterface
     */
    public function done(): TransactionInputInterface
    {
        return $this->input;
    }

    /**
     * @param array $array
     * @return $this
     */
    private function replace(array $array = [])
    {
        $this->input = new TransactionInput(
            array_key_exists('outpoint', $array) ? $array['outpoint'] : $this->input->getOutPoint(),
            array_key_exists('script', $array) ? $array['script'] : $this->input->getScript(),
            array_key_exists('nSequence', $array) ? $array['nSequence'] : $this->input->getSequence()
        );

        return $this;
    }

    /**
     * @param OutPointInterface $outPoint
     * @return InputMutator
     */
    public function outpoint(OutPointInterface $outPoint)
    {
        return $this->replace(array('outpoint' => $outPoint));
    }


    /**
     * @return $this
     */
    public function null()
    {
        return $this->replace(array('outpoint' => new OutPoint(new Buffer(str_pad('', 32, "\x00"), 32), 0xffffffff)));
    }

    /**
     * @param BufferInterface $txid
     * @return $this
     */
    public function txid(BufferInterface $txid)
    {
        return $this->replace(array('txid' => $txid));
    }

    /**
     * @param int $vout
     * @return InputMutator
     */
    public function vout(int $vout)
    {
        return $this->replace(array('vout' => $vout));
    }

    /**
     * @param ScriptInterface $script
     * @return $this
     */
    public function script(ScriptInterface $script)
    {
        return $this->replace(array('script' => $script));
    }

    /**
     * @param int $nSequence
     * @return $this
     */
    public function sequence(int $nSequence)
    {
        return $this->replace(array('nSequence' => $nSequence));
    }
}
