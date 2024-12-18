<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('signup', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('register', [SignupController::class, 'handleSignup'])->name('register');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'handleLogin']);

Route::middleware(AuthMiddleware::class)->group(function(){
    Route::prefix('admin')->middleware(['role:admin'])->group(function() {
        Route::resource('products', AdminProductController::class)->names([
            'show' => 'admin.products.show'
        ]);
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    });

    Route::get('products/', [ProductController::class, 'index'])->name('products');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{cartId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::put('/cart/{cartId}', [CartController::class, 'updateQuantity'])->name('cart.update');

    Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

    Route::get('wishlist', [WishlistController::class, 'viewWishlist'])->name('wishlist.index');
    Route::post('wishlist/{product}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::delete('wishlist/{product}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
    Route::post('wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});
