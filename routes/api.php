<?php

use App\Http\Controllers\Admin\AdminImportController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Profile\AdminProfileController;
use App\Http\Controllers\User\Auth\UserLoginController;
use App\Http\Controllers\User\Auth\UserProfileController;
use App\Http\Controllers\User\Auth\UserRegisterController;
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
    });
});
