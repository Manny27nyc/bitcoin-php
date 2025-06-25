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

namespace BitWasp\Bitcoin\Transaction\Bip69;

use BitWasp\Bitcoin\Script\ScriptWitnessInterface;
use BitWasp\Bitcoin\Transaction\Mutator\TxMutator;
use BitWasp\Bitcoin\Transaction\TransactionInputInterface;
use BitWasp\Bitcoin\Transaction\TransactionInterface;
use BitWasp\Bitcoin\Transaction\TransactionOutputInterface;

class Bip69
{
    /**
     * @param TransactionInputInterface[] $vTxin
     * @return TransactionInputInterface[]
     */
    public function sortInputs(array $vTxin): array
    {
        usort($vTxin, [$this, 'compareInputs']);
        return $vTxin;
    }

    /**
     * @param TransactionInputInterface $vin1
     * @param TransactionInputInterface $vin2
     * @return int
     */
    public function compareInputs(TransactionInputInterface $vin1, TransactionInputInterface $vin2): int
    {
        $outpoint1 = $vin1->getOutPoint();
        $outpoint2 = $vin2->getOutPoint();

        $cmpTxId = strcmp($outpoint1->getTxId()->getBinary(), $outpoint2->getTxId()->getBinary());

        return ($cmpTxId !== 0) ? $cmpTxId : $outpoint1->getVout() - $outpoint2->getVout();
    }

    /**
     * @param TransactionOutputInterface[] $vTxout
     * @return TransactionOutputInterface[]
     */
    public function sortOutputs(array $vTxout): array
    {
        usort($vTxout, [$this, 'compareOutputs']);
        return $vTxout;
    }

    /**
     * @param TransactionOutputInterface $vout1
     * @param TransactionOutputInterface $vout2
     * @return int
     */
    public function compareOutputs(TransactionOutputInterface $vout1, TransactionOutputInterface $vout2): int
    {
        $value = $vout1->getValue() - $vout2->getValue();

        return ($value !== 0) ? $value : strcmp($vout1->getScript()->getBinary(), $vout2->getScript()->getBinary());
    }

    /**
     * @param TransactionInterface $tx
     * @return bool
     */
    public function check(TransactionInterface $tx): bool
    {
        $inputs = $tx->getInputs();
        $outputs = $tx->getOutputs();

        return $this->sortInputs($inputs) === $inputs && $this->sortOutputs($outputs) === $outputs;
    }

    /**
     * @param TransactionInputInterface[] $inputs
     * @param ScriptWitnessInterface[] $witnesses
     * @return array
     * @throws \Exception
     */
    public function sortInputsAndWitness(array $inputs, array $witnesses): array
    {
        if (count($inputs) !== count($witnesses)) {
            throw new \Exception('Number of inputs must match witnesses');
        }

        uasort($inputs, [$this, 'compareInputs']);

        $vWitness = [];
        foreach ($inputs as $key => $input) {
            $vWitness[] = $witnesses[$key];
        }

        return [$inputs, $vWitness];
    }

    /**
     * @param TransactionInterface $tx
     * @return TransactionInterface
     */
    public function mutate(TransactionInterface $tx): TransactionInterface
    {
        if (count($tx->getWitnesses()) > 0) {
            list ($vTxin, $vWit) = $this->sortInputsAndWitness($tx->getInputs(), $tx->getWitnesses());
        } else {
            $vTxin = $this->sortInputs($tx->getInputs());
            $vWit = [];
        }

        return (new TxMutator($tx))
            ->inputs($vTxin)
            ->outputs($this->sortOutputs($tx->getOutputs()))
            ->witness($vWit)
            ->done();
    }
}
