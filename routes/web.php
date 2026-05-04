<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [ProdukController::class, 'index'])->name('index');

// Katalog produk
Route::get('/products', [ProdukController::class, 'catalog'])->name('products.index');
Route::get('/products/{produk}', [ProdukController::class, 'show'])->name('products.show');

// Keranjang (session-based, tanpa login)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

/*
|--------------------------------------------------------------------------
| Auth Routes (Guest only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (auth + admin/owner)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');

    // Kelola Produk
    Route::get('/products', [ProdukController::class, 'adminIndex'])->name('products.index');
    Route::post('/products', [ProdukController::class, 'store'])->name('products.store');
    Route::get('/products/{produk}/edit', [ProdukController::class, 'edit'])->name('products.edit');
    Route::put('/products/{produk}', [ProdukController::class, 'update'])->name('products.update');
    Route::delete('/products/{produk}', [ProdukController::class, 'destroy'])->name('products.destroy');

    // Kelola Pesanan
    Route::get('/orders', [PesananController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('orders.updateStatus');

    // Kelola User
    Route::get('/users', [UserController::class, 'userList'])->name('users.index');
});