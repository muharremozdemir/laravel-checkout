<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(25);

        return CategoryResource::collection($categories);
    }

    public function show($categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json([
                'data' => []
            ], 404);
        }
        $products = Product::where('category_id', $categoryId)->paginate(25);

        return response()->json([
            'data' => [
                'category' => CategoryResource::make($category),
                'products' => ProductResource::collection($products)
            ]
        ]);
    }
}
