<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'float',
        'preview' => 'array',
        'code' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * new instance from given cart item
     *
     * @param      CartItem  $cartItem
     *
     * @return     self
     */
    public static function newFromCartItem(CartItem $cartItem): self
    {
        $self = new self;

        // 保存商品快照
        $self->name = $cartItem->product->name;
        $self->preview = $cartItem->product->preview;
        $self->code = $cartItem->product->code;
        $self->price = $cartItem->product->price;

        $self->product()->associate($cartItem->product);

        return $self;
    }
}
