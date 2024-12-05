<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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
Route::prefix('admin')->group(function() {
    Route::resource('products', AdminProductController::class)->names([
        'show' => 'admin.products.show'
    ]);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
});
Route::get('products/', [ProductController::class, 'index'])->name('products');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
