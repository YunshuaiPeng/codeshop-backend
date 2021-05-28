<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'float',
        'preview' => 'array',
        'code' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCodeRowsAttribute(): int
    {
        return array_reduce($this->code, function ($carry, $item) {
            return $carry + substr_count($item, "\n");
        }, 0);
    }
}
