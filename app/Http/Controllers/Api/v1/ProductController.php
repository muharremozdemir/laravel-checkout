<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(25);

        return ProductResource::collection($products);
    }

    public function show($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'message' => 'Ürün bulunamadı',
                'data' => []
            ], 404);
        }

        $category = Category::find($product->category_id);
        return response()->json([
            'message' => 'Ürün başarıyla listelendi',
            'data' => [
                'category' => CategoryResource::make($category),
                'product' => ProductResource::make($product)
            ]
        ]);
    }
}
