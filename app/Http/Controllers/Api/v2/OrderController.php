<?php

namespace App\Http\Controllers\Api\v2;

use App\Events\CreateOrder;
use App\Events\UpdateOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProducts;
use Log;

class OrderController extends Controller
{
    public function create()
    {
        try {
            $user = auth()->user();
            $checkoutProducts = auth()->user()->checkout()->get();
            $orderPayload = [
                "user_id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "total_amount" => $checkoutProducts->sum('total_price')
            ];
            $order = Order::query()->create($orderPayload);

            foreach ($checkoutProducts as $checkoutProduct) {
                $orderProductPayload = [
                    "order_id" => $order->id,
                    "product_id" => $checkoutProduct->product_id,
                    "title" => $checkoutProduct->title,
                    "image" => $checkoutProduct->image,
                    "description" => $checkoutProduct->description,
                    "price" => $checkoutProduct->price,
                    "piece" => $checkoutProduct->piece,
                    "total_price" => $checkoutProduct->total_price
                ];
                OrderProducts::query()->create($orderProductPayload);
            }

            event(new CreateOrder($order));
            return OrderResource::make($order);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Bir hata oluştu'], 500);
        }
    }

    public function changeStatus(ChangeOrderStatusRequest $request)
    {
        $order = Order::query()->find($request->order_id);
        if (!$order){
            return response()->json([
                'message' => 'Sipariş bulunamadı',
                'data' => []
            ], 404);
        }
        $order->update(['status' => $request->status]);
        event(new UpdateOrder($order));
        return OrderResource::make($order->refresh());
    }
}
