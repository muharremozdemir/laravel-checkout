<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\DecreaseRequest;
use App\Http\Requests\IncreaseRequest;
use App\Http\Resources\CheckoutResource;
use App\Models\CheckoutProducts;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function getProduct($productId)
    {
        return Product::query()->find($productId);
    }

    public function addToCart(AddToCartRequest $request)
    {
        $user = auth()->user();
        $product = $this->getProduct($request->product_id);
        if (!$checkoutHaveProduct = $this->checkoutHaveProduct($user, $product)){
            $checkoutData = [
                "user_id" => $user->id,
                "product_id" => $product->id,
                "title" => $product->title,
                "image" => $product->image,
                "description" => $product->description,
                "price" => $product->price,
                "piece" => $request->input('piece') ?? 1,
                "total_price" => (double)$product->price * ($request->input('piece') ?? 1)
            ];
            CheckoutProducts::query()->create($checkoutData);
        }else{
            $checkoutHaveProduct->piece += $request->input('piece') ?? 1;
            $checkoutHaveProduct->total_price += ($request->input('piece') ?? 1) * $product->price;
            $checkoutHaveProduct->save();
        }
        return $this->getCheckout();
    }

    public function increaseQuantity(IncreaseRequest $request)
    {
        $product = $this->getProduct($request->product_id);
        $checkoutProduct = CheckoutProducts::query()->where(['user_id' => auth()->user()->id, 'product_id' => $product->id])->first();
        $checkoutProduct->piece++;
        $checkoutProduct->total_price = $checkoutProduct->total_price + $product->price;
        $checkoutProduct->save();
        return $this->getCheckout();
    }

    public function decreaseQuantity(DecreaseRequest $request)
    {
        $product = $this->getProduct($request->product_id);
        $checkoutProduct = CheckoutProducts::query()->where(['user_id' => auth()->user()->id, 'product_id' => $product->id])->first();
        $checkoutProduct->piece--;
        $checkoutProduct->total_price = $checkoutProduct->total_price - $checkoutProduct->price;
        $checkoutProduct->save();
        if ($checkoutProduct->piece == 0){
            $checkoutProduct->delete();
        }
        return $this->getCheckout();
    }

    public function removeProduct(Request $request)
    {
        $checkoutProduct = CheckoutProducts::query()->where(['user_id' => auth()->user()->id, 'product_id' => $request->product_id])->firstOrFail();
        if (!$checkoutProduct){
            return response()->json([
                'data' => []
            ], 404);
        }
        $checkoutProduct->delete();
        return $this->getCheckout();
    }

    public function getCheckout()
    {
        $checkoutProducts = CheckoutProducts::query()->where('user_id', auth()->user()->id)->get();
        return CheckoutResource::collection($checkoutProducts);
    }

    private function checkoutHaveProduct($user, $product)
    {
        return CheckoutProducts::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first();
    }
}
