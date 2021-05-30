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
        static $ids = [];

        start:
        $cartId = Cart::inRandomOrder()->first()->id;
        $productId = Product::inRandomOrder()->first()->id;

        if (in_array([$cartId, $productId], $ids)) {
            goto start;
        }

        $ids[] = [$cartId, $productId];

        return [
            'cart_id' => $cartId,
            'product_id' => $productId,
        ];
    }
}
