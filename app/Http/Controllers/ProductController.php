<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('category.parent');

        return new ProductResource($product);
    }
}
