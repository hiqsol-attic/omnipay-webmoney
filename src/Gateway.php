<?php

/*
 * WebMoney driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-webmoney
 * @package   omnipay-webmoney
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\WebMoney;

use Omnipay\Common\AbstractGateway;

/**
 * Gateway for WebMoney Web Merchant Interface.
 * https://wiki.wmtransfer.com/projects/webmoney/wiki/Web_Merchant_Interface.
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'WebMoney';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'testMode' => false,
        ];
    }

    /**
     * Get the unified purse.
     *
     * @return string merchant purse
     */
    public function getPurse()
    {
        return $this->getMerchantPurse();
    }

    /**
     * Set the unified purse.
     *
     * @param string $purse merchant purse
     *
     * @return self
     */
    public function setPurse($value)
    {
        return $this->setMerchantPurse($value);
    }

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
     * @param string $value merchant purse
     *
     * @return self
     */
    public function setMerchantPurse($value)
    {
        return $this->setParameter('merchantPurse', $value);
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
     * @param string $value secret key
     *
     * @return self
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\WebMoney\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\WebMoney\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\WebMoney\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\WebMoney\Message\CompletePurchaseRequest', $parameters);
    }
}
