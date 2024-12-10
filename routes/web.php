<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use Monolog\Handler\RotatingFileHandler;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SellerDashboardController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    // routes categories
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/categories', [CategoriesController::class, 'index'])->name('admin.categories');
    Route::post('admin/categories', [CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::put('admin/categories/{id}', [CategoriesController::class, 'update'])->name('admin.categories.update');
    Route::delete('admin/categories/{id}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

    //routes products
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // routes order
    Route::get('admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('admin/orders/{id}', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::get('admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('admin/orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('admin/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile', [ProfileUserController::class, 'index'])->name('user.profile');
    Route::get('/user/cart', [CartController::class, 'index'])->name('user.cart');
    Route::post('/user/cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/user/cart/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
