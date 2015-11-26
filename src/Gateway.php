<?php

/*
 * WebMoney driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-webmoney
 * @package   omnipay-webmoney
 * @license   MIT
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

    public function getAssetDir()
    {
        return dirname(__DIR__) . '/assets';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'merchantPurse' => '',
            'secretKey'     => '',
            'testMode'      => false,
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
     * Get the WebMoney ID.
     *
     * @return string WebMoney ID
     */
    public function getWebMoneyId()
    {
        return $this->getParameter('webMoneyId');
    }

    /**
     * Set the WebMoney ID.
     *
     * @param string $value WebMoney ID
     *
     * @return self
     */
    public function setWebMoneyId($value)
    {
        return $this->setParameter('webMoneyId', $value);
    }

    /**
     * Get the SSL file.
     *
     * @return string SSL file
     */
    public function getSslFile()
    {
        return $this->getParameter('sslFile');
    }

    /**
     * Set the SSL file.
     *
     * @param string $value SSL file
     *
     * @return self
     */
    public function setSslFile($value)
    {
        return $this->setParameter('sslFile', $value);
    }

    /**
     * Get the SSL key.
     *
     * @return string SSL key
     */
    public function getSslKey()
    {
        return $this->getParameter('sslKey');
    }

    /**
     * Set the SSL key.
     *
     * @param string $value SSL key
     *
     * @return self
     */
    public function setSslKey($value)
    {
        return $this->setParameter('sslKey', $value);
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
