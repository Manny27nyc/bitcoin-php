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

namespace BitWasp\Bitcoin;

use BitWasp\Bitcoin\Address\AddressInterface;
use BitWasp\Bitcoin\Network\NetworkInterface;

class Uri
{
    const BIP0021 = 0;
    const BIP0072 = 1;

    /**
     * @var AddressInterface
     */
    private $bip21Address;

    /**
     * @var AddressInterface|null
     */
    private $bip72Address;

    /**
     * @var null|string
     */
    private $amount;

    /**
     * @var string|null
     */
    private $label;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $request;

    /**
     * @var int
     */
    private $rule;

    /**
     * Uri constructor.
     * @param AddressInterface|null $address
     * @param int $convention
     */
    public function __construct(AddressInterface $address = null, int $convention = self::BIP0021)
    {
        if ($convention === self::BIP0021) {
            if ($address === null) {
                throw new \InvalidArgumentException('Cannot provide a null address with bip0021');
            }
            $this->bip21Address = $address;
        } else if ($convention === self::BIP0072) {
            $this->bip72Address = $address;
        } else {
            throw new \InvalidArgumentException("Invalid convention for bitcoin uri");
        }

        $this->rule = $convention;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAmountBtc(string $value)
    {
        $this->amount = $value;
        return $this;
    }

    /**
     * @param Amount $amount
     * @param int $value
     * @return $this
     */
    public function setAmount(Amount $amount, int $value)
    {
        $this->amount = $amount->toBtc($value);
        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setRequestUrl(string $url)
    {
        $this->request = $url;
        return $this;
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function uri(NetworkInterface $network = null): string
    {
        if ($this->rule === self::BIP0072) {
            $address = $this->bip72Address === null ? '' : $this->bip72Address->getAddress($network);
        } else {
            $address = $this->bip21Address->getAddress($network);
        }

        $url = 'bitcoin:' . $address;

        $params = [];
        if (null !== $this->amount) {
            $params['amount'] = $this->amount;
        }

        if (null !== $this->label) {
            $params['label'] = $this->label;
        }

        if (null !== $this->message) {
            $params['message'] = $this->message;
        }

        if (null !== $this->request) {
            $params['r'] = $this->request;
        }

        if (count($params) > 0) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
}
