<?php

namespace App\Models;

use App\Contracts\Payable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_PAID = 'paid';
    const STATUS_UNPAID = 'unpaid';
    const STATUS_CANCELED = 'canceled';

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
            $self->identifier = number_format(microtime(true), 4, '', '');
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('identifier', $value)->firstOrFail();
    }

    public function payable()
    {
        return $this->morphTo();
    }

    /**
     * 用一个实现了 Payable 的实例生成 Payment
     *
     * @param      \App\Contracts\Payable  $payable
     *
     * @return     self
     */
    public static function newInstanceFromPayable(Payable $payable)
    {
        $self = new self;
        $self->payable()->associate($payable);
        $self->amount = $payable->getAmount();
        return $self;
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

    public function pay(): self
    {
        if ($this->status != self::STATUS_UNPAID) {
            info("Payment@pay - {$this->identifier} already paid");
            return $this;
        }

        $this->status = self::STATUS_PAID;
        $this->save();
        $this->payable->onPaid();
        return $this;
    }

    public function cancle(): self
    {
        if (!$this->is_unpaid) {
            info("Payment@cancle - try to cancle but it's not unpaid [{$this->identifier}] ");
            return $this;
        }

        $this->status = self::STATUS_CANCELED;
        $this->save();
        return $this;
    }
}
