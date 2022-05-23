<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Basket\BasketController;
use App\Http\Controllers\MainController;
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
    'verify' => false,
    'register' => false
]);

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'create'])->name('register');

Route::post('/login/check', [\App\Http\Controllers\Auth\CheckCreditsController::class, 'login'])->name('native');

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('get-logout');

Route::get('/locale/{locale}', [MainController::class, 'changeLocale'])->name('locale');

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
                Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
                Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
            });

            Route::resource('products', ProductController::class);
            Route::resource('categories', CategoryController::class);
        });
    });

    Route::get('/', [MainController::class, 'index'])->name('home');

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

    //Social Auth
    Route::get('/auth/{type}', [\App\Http\Controllers\SocialController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{type}/callback', [\App\Http\Controllers\SocialController::class, 'login'])->name('social.login');
});
