<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * 增加商品到购物车
     *
     * @param      <int|array>  $productIds  商品ID
     *
     * @return     self
     */
    public function add($productIds): self
    {
        if (!is_array($productIds)) {
            $productIds = func_get_args();
        }

        $products = Product::findOrFail($productIds);

        $rows = $products->map(function ($product) {
            return [
                'cart_id' => $this->id,
                'product_id' => $product->id,
            ];
        })->toArray();

        CartItem::upsert($rows, ['cart_id', 'product_id']);

        $this->touch();

        return $this;
    }
}
