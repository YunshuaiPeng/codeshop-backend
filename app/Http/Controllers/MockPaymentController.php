<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * 模拟支付
 */
class MockPaymentController extends Controller
{
    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function pay(Payment $payment)
    {
        if ($payment->is_paid) {
            return response()->json([
                'message' => "订单 {$payment->payable->identifier} 已支付，无需再次操作",
            ]);
        }

        $payment->pay();

        return response()->json([
            'message' => "订单 {$payment->payable->identifier} 支付成功",
        ]);
    }
}
