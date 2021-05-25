<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $models = Category::query()
            ->whereNull('pid')
            ->with([
                'children' => function ($query) {
                    $query->withCount('products');
                },
            ])
            ->orderBy('sort')
            ->get();

        return CategoryResource::collection($models);
    }

    public function show(Category $category)
    {
        $category->load(['products', 'parent']);

        return new CategoryResource($category);
    }
}
