<?php

namespace App\Observers;

use App\Exceptions\CartExistsException;
use App\Models\Cart;

class CartObserver
{
    public function creating(Cart $cart)
    {
        $count = $cart->user->cart()->count();

        if ($count > 0) {
            throw new CartExistsException;
        }
    }
}
