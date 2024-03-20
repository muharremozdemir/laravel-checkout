<?php

use App\Http\Controllers\Api\v2\AuthController;
use App\Http\Controllers\Api\v2\CategoryController;
use App\Http\Controllers\Api\v2\CheckoutController;
use App\Http\Controllers\Api\v2\OrderController;
use App\Http\Controllers\Api\v2\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('check-user', [AuthController::class, 'checkUser']);
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('update-profile', [AuthController::class, 'updateProfile']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{categoryId}', [CategoryController::class, 'show']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{productId}', [ProductController::class, 'show']);

    Route::group(['prefix' => 'checkout'], function (){
        Route::post('add-to-cart', [CheckoutController::class, 'addToCart']);
        Route::post('increase-quantity', [CheckoutController::class, 'increaseQuantity']);
        Route::post('decrease-quantity', [CheckoutController::class, 'decreaseQuantity']);
        Route::post('remove-product', [CheckoutController::class, 'removeProduct']);
        Route::get('get-checkout', [CheckoutController::class, 'getCheckout']);
    });

    Route::group(['prefix' => 'order'], function (){
        Route::post('create', [OrderController::class, 'create']);
        Route::post('change-status', [OrderController::class, 'changeStatus']);
    });
});
