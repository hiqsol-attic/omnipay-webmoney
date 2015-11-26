<?php

/*
 * WebMoney driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-webmoney
 * @package   omnipay-webmoney
 * @license   MIT
 * @copyright Copyright (c) 2015, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\WebMoney\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'merchantPurse' => 'Z123428476799',
            'secretKey' => '226778888',
            'returnUrl' => 'https://www.foodstore.com/success',
            'cancelUrl' => 'https://www.foodstore.com/failure',
            'notifyUrl' => 'https://www.foodstore.com/notify',
            'description' => 'Test Transaction',
            'transactionId' => '1234567890',
            'amount' => '14.65',
            'currency' => 'USD',
            'testMode' => true,
        ]);
    }

    public function testException()
    {
        $this->request->setCurrency('EUR');

        try {
            $this->request->getData();
        } catch (\Exception $e) {
            $this->assertEquals('Omnipay\Common\Exception\InvalidRequestException', get_class($e));
        }
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('Z123428476799', $data['LMI_PAYEE_PURSE']);
        $this->assertSame('14.65', $data['LMI_PAYMENT_AMOUNT']);
        $this->assertSame('1234567890', $data['LMI_PAYMENT_NO']);
        $this->assertSame('VGVzdCBUcmFuc2FjdGlvbg==', $data['LMI_PAYMENT_DESC_BASE64']);
        $this->assertSame('2', $data['LMI_SIM_MODE']);
        $this->assertSame('https://www.foodstore.com/notify', $data['LMI_RESULT_URL']);
        $this->assertSame('https://www.foodstore.com/success', $data['LMI_SUCCESS_URL']);
        $this->assertSame('0', $data['LMI_SUCCESS_METHOD']);
        $this->assertSame('https://www.foodstore.com/failure', $data['LMI_FAIL_URL']);
        $this->assertSame('0', $data['LMI_FAIL_METHOD']);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WebMoney\Message\PurchaseResponse', get_class($response));
    }

    public function testDetectCurrency()
    {
        $this->assertSame('USD', $this->request->detectCurrency('Z123428476799'));
        $this->assertSame('RUB', $this->request->detectCurrency('R123428476799'));
        $this->assertSame('EUR', $this->request->detectCurrency('E123428476799'));
        $this->assertSame('UAH', $this->request->detectCurrency('U123428476799'));
        $this->assertSame('KZT', $this->request->detectCurrency('K123428476799'));
        $this->assertSame('UZS', $this->request->detectCurrency('Y123428476799'));
        $this->assertSame('BYR', $this->request->detectCurrency('B123428476799'));
        $this->assertSame('BTC', $this->request->detectCurrency('X123428476799'));
        $this->assertSame(null,  $this->request->detectCurrency('A123428476799'));
    }
}
