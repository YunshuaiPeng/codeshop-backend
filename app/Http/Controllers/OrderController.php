<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $params = $request->validate([
            'amount' => 'required|numeric|min:0',
            'cart_items' => 'required|array',
            'cart_items.*' => 'required|integer',
        ]);

        info("OrderController@store [{$request->user()->id}] - start", $params);

        $cartItems = CartItem::findOrFail($request->cart_items);

        $order = Order::createFromCartItems(
            $cartItems,
            function ($order) use ($request) {
                $order->validateAmount($request->amount);
            }
        );

        $order->load(['payment']);

        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['items.product', 'payment']);

        return new OrderResource($order);
    }

    public function index(Request $request)
    {
        $request->validate([
            'status' => [
                'nullable',
                'string',
                Rule::in(Order::STATUSES),
            ]
        ]);

        $orders = Auth::user()
            ->orders()
            ->when(
                $request->status ?? false,
                function ($query) use ($request) {
                    $query->isStatus($request->status);
                }
            )
            ->get();

        return OrderResource::collection($orders);
    }
}
