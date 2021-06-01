<?php

namespace App\Observers;

use App\Jobs\CancelOrderJob;
use App\Models\Order;

class OrderObserver
{
    public function created(Order $order)
    {
        CancelOrderJob::dispatch($order)->delay(now()->addMinute(10));
    }
}
