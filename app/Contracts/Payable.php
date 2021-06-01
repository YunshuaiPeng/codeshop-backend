<?php

namespace App\Contracts;

interface Payable
{
    /**
     * 支付成功之后的回调
     */
    public function onPaid();

    /**
     * 获取应该支付的金额
     *
     * @return     float
     */
    public function getAmount(): float;
}
