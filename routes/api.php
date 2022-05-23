<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Basket\BasketController;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [\App\Http\Controllers\AuthController::class, 'me']);
});


Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/', [\App\Http\Controllers\MainController::class, 'index']);
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::group([
        'prefix' => 'person',
        'as' => 'person.',
    ], function () {
        Route::get('/orders', [\App\Http\Controllers\Person\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Person\OrderController::class, 'show'])->name('orders.show');
    });

    Route::group([
        'prefix' => 'admin',
    ], function () {
        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        });

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
    });

    Route::group(['prefix' => 'basket'], function () {
        Route::post('/add/{product}', [BasketController::class, 'store'])->name('basket-add');
        Route::get('/', [BasketController::class, 'basket'])->name('basket');
        Route::group(['middleware' => 'basket_not_empty'], function () {
            Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket-place');
            Route::post('/place', [BasketController::class, 'basketConfirm'])->name('basket-confirm');
            Route::post('/remove/{product}', [BasketController::class, 'remove'])->name('basket-remove');
        });
    });

    Route::post('/subscription/{product}', [MainController::class, 'subscribe'])->name('subscription');

    Route::get('/categories', [MainController::class, 'categories'])->name('categories');
    Route::get('/category/{category}', [MainController::class, 'category'])->name('category');
    Route::get('/categories/{category}/{product}', [MainController::class, 'product'])->name('product');

});


