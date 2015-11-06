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

/**
 * WebMoney Complete Purchase Request
 * https://merchant.wmtransfer.com/conf/guide.asp.
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * Get the data for this request.
     *
     * @return array request data
     */
    public function getData()
    {
        $this->validate(
            'merchantPurse',
            'secretKey'
        );

        $res = [];
        foreach ($this->httpRequest->request->all() as $k => $v) {
            if (substr($k, 0, 4) === 'LMI_') {
                $res[$k] = $v;
            }
        }

        return $res;
    }

    /**
     * Send the request with specified data.
     *
     * @param mixed $data The data to send
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
