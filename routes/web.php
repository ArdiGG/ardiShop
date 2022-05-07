<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/test', function () {
    DB::insert('INSERT INTO popa (id, popa) VALUES (:id , :popa)', ['id' => 1, 'popa' => 'popa']);
});

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('get-logout');

Route::get('/locale/{locale}', [\App\Http\Controllers\MainController::class, 'changeLocale'])->name('locale');

Route::get('/reset', [\App\Http\Controllers\ResetController::class, 'reset'])->name('reset');

Route::middleware('set_locale')->group(function () {

    Route::middleware(['auth'])->group(function () {
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
                Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
                Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
            });

            Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
            Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        });
    });

    Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('home');

    Route::group(['prefix' => 'basket'], function () {
        Route::post('/add/{product}', [\App\Http\Controllers\BasketController::class, 'store'])->name('basket-add');
        Route::get('/', [\App\Http\Controllers\BasketController::class, 'basket'])->name('basket');
        Route::group(['middleware' => 'basket_not_empty'], function () {
            Route::get('/place', [\App\Http\Controllers\BasketController::class, 'basketPlace'])->name('basket-place');
            Route::post('/place', [\App\Http\Controllers\BasketController::class, 'basketConfirm'])->name('basket-confirm');
            Route::post('/remove/{product}', [\App\Http\Controllers\BasketController::class, 'remove'])->name('basket-remove');
        });
    });

    Route::post('/subscription/{product}', [\App\Http\Controllers\MainController::class, 'subscribe'])->name('subscription');

    Route::get('/categories', [\App\Http\Controllers\MainController::class, 'categories'])->name('categories');
    Route::get('/category/{category}', [\App\Http\Controllers\MainController::class, 'category'])->name('category');
    Route::get('/categories/{category}/{product}', [\App\Http\Controllers\MainController::class, 'product'])->name('product');

    //authWithGoogle
    Route::get('/auth/google', [\App\Http\Controllers\SocialController::class, 'googleRedirect'])->name('google');
    Route::get('/auth/google/callback', [\App\Http\Controllers\SocialController::class, 'loginWithGoogle']);

    //authWithFacebook
    Route::get('/auth/facebook', [\App\Http\Controllers\SocialController::class, 'facebookRedirect'])->name('facebook');
    Route::get('/auth/facebook/callback', [\App\Http\Controllers\SocialController::class, 'loginWithFacebook']);

});
