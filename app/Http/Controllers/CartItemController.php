<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'required|int',
        ]);

        $cart = Auth::user()->cart;

        $cart->add($request->product_ids);

        $cart->load('items.product');

        return new CartResource($cart);
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
    }
}
