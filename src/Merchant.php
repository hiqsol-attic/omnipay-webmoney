<?php

/*
 * WebMoney plugin for PHP merchant library
 *
 * @link      https://github.com/hiqdev/php-merchant-webmoney
 * @package   php-merchant-webmoney
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015, HiQDev (https://hiqdev.com/)
 */

namespace hiqdev\php\merchant\webmoney;

class Merchant extends \hiqdev\php\merchant\webmoney\Merchant
{
    protected static $_defaults = [
        'name'        => 'webmoney',
        'label'       => 'WebMoney',
        'actionUrl'   => 'https://merchant.webmoney.ru/lmi/payment.asp',
        'confirmText' => 'OK',
    ];

    public function getInputs()
    {
        return [
            'LMI_PAYMENT_DESC'   => $this->description,
            'LMI_PAYEE_PURSE'    => $this->purse,
            'LMI_PAYMENT_AMOUNT' => $this->total,
            'LMI_RESULT_URL'     => $this->confirmUrl,
            'LMI_SUCCESS_URL'    => $this->successUrl,
            'LMI_FAIL_URL'       => $this->failureUrl,
            'LMI_SUCCESS_METHOD' => 1,
            'LMI_FAIL_METHOD'    => 1,
        ];
    }

    public function validateConfirmation($data)
    {
    }
}
