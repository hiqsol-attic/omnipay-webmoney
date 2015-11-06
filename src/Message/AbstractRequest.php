<?php

namespace Omnipay\WebMoney\Message;

/**
 * WebMoney Abstract Request.
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $zeroAmountAllowed = false;

    protected $endpoint = 'https://w3s.wmtransfer.com/asp/XMLTransCert.asp';

    /**
     * Get the merchant purse.
     *
     * @return string merchant purse
     */
    public function getMerchantPurse()
    {
        return $this->getParameter('merchantPurse');
    }

    /**
     * Set the merchant purse.
     *
     * @param string $purse merchant purse
     *
     * @return self
     */
    public function setMerchantPurse($purse)
    {
        return $this->setParameter('merchantPurse', $purse);
    }

    /**
     * Get the secret key.
     *
     * @return string secret key
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set the secret key.
     *
     * @param string $key secret key
     *
     * @return self
     */
    public function setSecretKey($key)
    {
        return $this->setParameter('secretKey', $key);
    }

    static protected $_currencies = [
        'Z' => 'USD',
        'E' => 'EUR',
        'R' => 'RUB',
        'U' => 'UAH',
        'B' => 'BYR',
        'V' => 'VND',
        'G' => 'GOLD',
        'X' => 'BITCOIN',
    ];

    /**
     * Detect currency.
     */
    public function detectCurrency($purse)
    {
        return self::$_currencies[strtoupper($purse[0])];
    }

}
