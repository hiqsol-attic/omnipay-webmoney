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

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public $gateway;
    public $webMoneyId    = '0811333344777';
    public $merchantPurse = 'Z123428476799';
    public $secretKey     = 's2#$%_$#267sd';
    public $transactionId = '1444212666';
    public $sslFile;
    public $sslKey;

    public function setUp()
    {
        parent::setUp();

        $class = new \ReflectionObject($this);
        $directory = dirname($class->getFileName());
        $this->sslFile = realpath($directory . '/Certificate/webmoney.pem');
        $this->sslKey = realpath($directory . '/Certificate/webmoney.key');

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setWebMoneyId($this->webMoneyId);
        $this->gateway->setMerchantPurse($this->merchantPurse);
        $this->gateway->setSecretKey($this->secretKey);
        $this->gateway->setSsLFile($this->sslFile);
        $this->gateway->setSslKey($this->sslKey);
        $this->gateway->setTestMode(true);
    }

    public function testGateway()
    {
        $this->assertSame($this->webMoneyId,    $this->gateway->getWebMoneyId());
        $this->assertSame($this->merchantPurse, $this->gateway->getMerchantPurse());
        $this->assertSame($this->secretKey,     $this->gateway->getSecretKey());
        $this->assertSame($this->sslFile,       $this->gateway->getSslFile());
        $this->assertSame($this->sslKey,        $this->gateway->getSslKey());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'transactionId' => $this->transactionId,
        ]);

        $this->assertSame($this->transactionId, $request->getTransactionId());
    }
}
