<?php

/*
 * WebMoney driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-webmoney
 * @package   omnipay-webmoney
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\WebMoney\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate(
            'merchantPurse',
            'amount',
            'currency',
            'description',
            'transactionId',
            'returnUrl',
            'cancelUrl',
            'notifyUrl'
        );

        if ($this->detectCurrency($this->getMerchantPurse()) !== $this->getCurrency()) {
            throw new InvalidRequestException('Invalid currency for this merchant purse');
        }

        return [
            'LMI_PAYEE_PURSE'         => $this->getMerchantPurse(),
            'LMI_PAYMENT_AMOUNT'      => $this->getAmount(),
            'LMI_PAYMENT_NO'          => $this->getTransactionId(),
            'LMI_PAYMENT_DESC_BASE64' => base64_encode($this->getDescription()),
            'LMI_RESULT_URL'          => $this->getNotifyUrl(),
            'LMI_SUCCESS_URL'         => $this->getReturnUrl(),
            'LMI_FAIL_URL'            => $this->getCancelUrl(),
            'LMI_SUCCESS_METHOD'      => '0',
            'LMI_FAIL_METHOD'         => '0',
        ];
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
