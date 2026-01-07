<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController; // Ganti ini

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Guest Only (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Must Login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Only
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [TransactionController::class, 'dashboard'])->name('dashboard');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    });

    // Admin & Kasir Bisa Akses
    Route::get('/kasir', [TransactionController::class, 'index'])->name('kasir.index');
    Route::get('/history', [TransactionController::class, 'history'])->name('transaction.history');
    Route::get('/receipt/{id}', [TransactionController::class, 'receipt'])->name('transaction.receipt');
});
Route::get('/', function () {
    return view('welcome');
});

// Route Produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Route Kasir
Route::get('/kasir', [TransactionController::class, 'index'])->name('kasir.index');
Route::get('/add-to-cart/{id}', [TransactionController::class, 'addToCart'])->name('cart.add');
Route::get('/clear-cart', [TransactionController::class, 'clearCart'])->name('cart.clear');
Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
Route::get('/receipt/{id}', [TransactionController::class, 'receipt'])->name('transaction.receipt');
Route::get('/history', [TransactionController::class, 'history'])->name('transaction.history');
Route::get('/dashboard', [TransactionController::class, 'dashboard'])->name('dashboard');
