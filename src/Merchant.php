<?php

/*
 * WebMoney plugin for PHP merchant library
 *
 * @link      https://github.com/hiqdev/php-merchant-webmoney
 * @package   php-merchant-webmoney
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\php\merchant\webmoney;

class Merchant extends \hiqdev\php\merchant\Merchant
{
    protected static $_defaults = [
        'system'    => 'webmoney',
        'label'     => 'WebMoney',
        'actionUrl' => 'https://merchant.webmoney.ru/lmi/payment.asp',
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
        if ($data['LMI_PREREQUEST']) {
            die(json_encode('YES')); /// this is preliminary request
        }
        if ($data['LMI_MODE']) {
            return "Wrong LMI MODE:$data[LMI_MODE]";
        }
        $sum = $this->checkMoney($data['LMI_PAYMENT_AMOUNT']);
        if (!$sum) {
            return [];
        }
        $str = implode('', [
            $this->purse, $data['LMI_PAYMENT_AMOUNT'], $data['LMI_PAYMENT_NO'], $data['LMI_MODE'], $data['LMI_SYS_INVS_NO'],
            $data['LMI_SYS_TRANS_NO'], $data['LMI_SYS_TRANS_DATE'], $this->key, $data['LMI_PAYER_PURSE'], $data['LMI_PAYER_WM'],
        ]);
        $hash = strtolower($data['LMI_HASH']);
        if ($hash !== md5($str) && $hash !== hash('sha256', $str)) {
            return 'Wrong hash';
        }
        $this->mset([
            'from' => "$data[LMI_PAYER_PURSE]/$data[LMI_PAYER_WM]",
            'txn'  => "$data[LMI_SYS_INVS_NO]/$data[LMI_SYS_TRANS_NO]",
            'sum'  => $sum,
            'time' => $this->formatDatetime("$data[LMI_SYS_TRANS_DATE] Europe/Moscow"),
        ]);

        return;
    }
}
