<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $casts = [
        'sort' => 'int'
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'pid')->orderBy('sort');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'pid');
    }

    public function progeny()
    {
        return $this->children()->with('progeny');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
