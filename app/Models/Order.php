<?php

namespace App\Models;

use App\Contracts\Payable;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model implements Payable
{
    use HasFactory;

    const STATUS_PAID = 'paid';
    const STATUS_UNPAID = 'unpaid';
    const STATUS_CANCELED = 'canceled';

    const STATUSES = [
        self::STATUS_PAID,
        self::STATUS_UNPAID,
        self::STATUS_CANCELED,
    ];

    protected $casts = [
        'amount' => 'float',
        'id_paid' => 'boolean',
        'id_unpaid' => 'boolean',
        'id_canceled' => 'boolean',
    ];

    protected $attributes = [
        'status' => self::STATUS_UNPAID,
    ];

    protected $appends = [
        'id_paid',
        'id_unpaid',
        'id_canceled',
    ];

    protected static function booted()
    {
        self::creating(function ($self) {
            $self->identifier = self::generateIdentifier();
            $self->user()->associate(Auth::user());
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('identifier', $value)->firstOrFail();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->status == self::STATUS_PAID;
    }

    public function getIsUnpaidAttribute(): bool
    {
        return $this->status == self::STATUS_UNPAID;
    }

    public function getIsCanceledAttribute(): bool
    {
        return $this->status == self::STATUS_CANCELED;
    }

    public function scopeIsStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public static function generateIdentifier()
    {
        return today()->format('ymd') . sprintf("%08d", random_int(0, 99999999));
    }

    public function createPayment()
    {
        Payment::newInstanceFromPayable($this)->save();
    }

    /**
     * 实现 \App\Contracts\Payable@onPaid
     */
    public function onPaid()
    {
        $this->status = self::STATUS_PAID;
        $this->save();
    }

    /**
     * 实现 \App\Contracts\Payable@getAmount
     *
     * @return     float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * 验证给定的金额与订单金额是否相符
     *
     * @param      float  $amount  The amount
     */
    public function validateAmount(float $amount)
    {
        if (bccomp($amount, $this->amount, 2) != 0) {
            info("Order@validateAmount - given amount is $amount - actual amount is $this->amount");
            abort(400, "amount don't match order amount");
        }
    }

    /**
     * 从购物车生成订单
     *
     * @param      \Illuminate\Database\Eloquent\Collection  $cartItems
     */
    public static function createFromCartItems(
        Collection $cartItems,
        Closure $beforeOrderSaving = null
    ): self {
        $cartItems->load([
            'product'
        ]);

        $order = new self;
        $order->amount = $cartItems->sum(fn ($item) => $item->product->price);

        $orderItems = $cartItems->map(fn ($cartItem) => OrderItem::newFromCartItem($cartItem));

        if ($beforeOrderSaving instanceof Closure) {
            call_user_func($beforeOrderSaving, $order);
        }

        return DB::transaction(function () use (
            $order,
            $orderItems,
            $cartItems,
        ) {
            // 保存订单
            $order->save();
            // 保存订单 items
            $order->items()->saveMany($orderItems);
            // 创建 payment
            $order->createPayment();
            // 清除 cart items
            $cartItems->each->delete();

            return $order;
        });
    }

    public function cancle(): self
    {
        if (!$this->is_unpaid) {
            info("Order@cancle - try to cancle but it's not unpaid [{$this->identifier}] ");
            return $this;
        }

        return DB::transaction(function () {
            $this->status = self::STATUS_CANCELED;
            $this->save();
            $this->payment->cancle();
            return $this;
        });
    }
}
