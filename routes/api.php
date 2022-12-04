<?php

use App\Http\Controllers\Admin\AdminImportController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Profile\AdminProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\Auth\UserLoginController;
use App\Http\Controllers\User\Auth\UserProfileController;
use App\Http\Controllers\User\Auth\UserRegisterController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->group(function () {
    Route::post('login', [AdminLoginController::class, 'login'])->middleware(['guest:api']);

    Route::middleware(['auth:api', 'role:admin'])->group(function () {
        Route::get('profile', [AdminProfileController::class, 'profile']);
        Route::post('logout', [AdminProfileController::class, 'logout']);

        Route::post('products/import', [AdminImportController::class, 'importProducts']);
    });
});

Route::prefix('user')->group(function () {
    Route::middleware(['guest:api'])->group(function () {
        Route::post('login', [UserLoginController::class, 'login']);
        Route::post('register', [UserRegisterController::class, 'register']);
    });

    Route::middleware(['auth:api', 'role:user'])->group(function () {
        Route::get('profile', [UserProfileController::class, 'profile']);
        Route::post('logout', [UserProfileController::class, 'logout']);

        //Using separate routes instead of using the apiResource for readability
        Route::get('cart-data', [UserCartController::class, 'cartData']);
        Route::post('add-item-to-cart', [UserCartController::class, 'addToCart']);
        Route::delete('remove-item-from-cart/{cart_item_id}', [UserCartController::class, 'removeFromCart']);
        Route::patch('update-item-qty/{cart_item_id}', [UserCartController::class, 'updateItemQuantity']);
        Route::delete('delete-cart', [UserCartController::class, 'deleteCart']);

        Route::post('orders', [UserOrderController::class, 'placeAnOrder']);
        Route::get('orders', [UserOrderController::class, 'myOrders']);
    });
});

Route::apiResource('products', ProductController::class)->only(['index', 'show']);
