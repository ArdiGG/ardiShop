<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false
]);

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('get-logout');

Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin',
], function () {
    Route::group(['middleware' => 'is_admin'], function () {
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('home');
    });

    Route::resource('products',  \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
});

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('index');

Route::group(['prefix' => 'basket'], function (){
    Route::get('/', [\App\Http\Controllers\BasketController::class, 'basket'])->name('basket');
    Route::get('/place', [\App\Http\Controllers\BasketController::class, 'basketPlace'])->name('basket-place');
    Route::post('/place', [\App\Http\Controllers\BasketController::class, 'basketConfirm'])->name('basket-confirm');
    Route::post('/add/{id}',[\App\Http\Controllers\BasketController::class, 'store'])->name('basket-add');
    Route::post('/remove/{id}', [\App\Http\Controllers\BasketController::class, 'remove'])->name('basket-remove');
});

Route::get('/categories', [\App\Http\Controllers\MainController::class, 'categories'])->name('categories');
Route::get('/category/{category}', [\App\Http\Controllers\MainController::class, 'category'])->name('category');
Route::get('/{category}/{product}', [\App\Http\Controllers\MainController::class, 'product'])->name('product');

