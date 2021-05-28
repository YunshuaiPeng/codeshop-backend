<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cartIds = Cart::query()->get('id');
        $productIds = Product::query()->get('id');
        return [
            'cart_id' => $cartIds->random(),
            'product_id' => $productIds->random(),
        ];
    }
}
