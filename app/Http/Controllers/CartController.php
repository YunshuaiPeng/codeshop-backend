<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $cart = Auth::user()
            ->cart()
            ->with('items.product')
            ->first();

        return new CartResource($cart);
    }
}
